<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

use App\Models\Customer;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Schema;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    // List customers
    public function index(Request $request)
    {
        $user = auth()->user();

        // Base query with agent and scheme relation
        $query = Customer::with(['agent', 'scheme']);

        // Restrict data for agents (role_id = 3)
        if ($user->role_id == 3) {
            $query->where('agent_id', $user->id);
        }

        // ✅ Scheme filter (पहले scheme lock करो)
        if ($request->filled('scheme_id')) {
            $query->where('scheme_id', $request->scheme_id);
        }

        // ✅ Search filter (name, email, mobile, mtoken) → scheme filter के अंदर ही चलेगा
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('mtoken', 'like', "%{$search}%"); // 👈 mtoken भी added
            });
        }

        // ✅ Status filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', 1);
                    break;
                case 'inactive':
                    $query->where('is_active', 0);
                    break;
                case 'pending':
                    $query->where('verification_status', 'pending');
                    break;
            }
        }

        // Get customers with pagination (latest first)
        $customers = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistics
        $stats = [
            'today_new' => Customer::whereDate('created_at', today())->count(),
            'active_count' => Customer::where('is_active', 1)->count(),
            'inactive_pending_count' => Customer::where(function ($q) {
                $q->where('is_active', 0)
                    ->orWhere('verification_status', 'pending');
            })->count(),
        ];

        // ✅ Load all schemes for filter dropdown
        $schemes = \App\Models\Scheme::all();

        // AJAX request
        if ($request->ajax()) {
            $table = view('admin.customers.partials.table', compact('customers'))->render();
            $pagination = view('admin.customers.partials.pagination', compact('customers'))->render();

            return response()->json([
                'table' => $table,
                'pagination' => $pagination,
                'stats' => $stats
            ]);
        }

        // Normal request
        return view('admin.customers.index', compact('customers', 'stats', 'schemes'));
    }

    // Show create form
    public function create()
    {
        $user = auth()->user();
        $schemes = Scheme::all();
        $agents = $user->role_id == 3 ? [] : User::where('role_id', 3)->get();
        return view('admin.customers.create', compact('agents', 'schemes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'mobile' => 'required|string|max:15|unique:customers,mobile',
            'address' => 'required|string|max:500',
            'is_active' => 'required|boolean',
            'agent_id' => 'nullable|exists:users,id',
            'scheme_id' => 'required|exists:schemes,id', // ✅ scheme_id required
            'scheme' => 'nullable|string|max:255',
            'mtoken' => 'nullable|string|max:255',
            'scheme_duration' => 'nullable|string',
            'scheme_total_amount' => 'nullable|numeric',
            'payment_link' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ✅ Duplicate mtoken check for same scheme
        if (!empty($request->mtoken) && !empty($request->scheme_id)) {
            $exists = Customer::where('scheme_id', $request->scheme_id)
                ->where('mtoken', $request->mtoken)
                ->exists();

            if ($exists) {
                $errorMessage = "This MToken already exists in the selected scheme!";
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage
                    ], 422);
                }
                return redirect()->back()->with('error', $errorMessage)->withInput();
            }
        }

        $user = auth()->user();
        $agent_id = $user->role_id == 3 ? $user->id : $request->agent_id;

        try {
            // Token generate
            $token = strtoupper(uniqid('TKN-'));
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'is_active' => $request->is_active,
                'agent_id' => $agent_id,
                'token' => $token,
                'scheme_duration' => $request->scheme_duration,
                'scheme_total_amount' => $request->scheme_total_amount,
                'mtoken' => $request->mtoken,
                'verification_status' => 'pending',
                'payment_status' => 'pending',
                'payment_link' => $request->payment_link ?? null,
                'scheme' => $request->scheme ?? 'Not Provided',
                'scheme_id' => $request->scheme_id
            ]);

            // QR Data
            $qrData = [
                'name' => $customer->name,
                'mobile' => $customer->mobile,
                'email' => $customer->email ?? 'Not Provided',
                'token' => $customer->token,
                'scheme' => $customer->scheme,
                'mtoken' => $customer->mtoken,
                'use' => 'Verification / Check-in / Order Reference',
                'payment_status' => $customer->payment_status,
                'payment_link' => $customer->payment_link
            ];

            // Generate QR URL
            $qrUrl = "https://quickchart.io/qr?text=" . urlencode(json_encode($qrData)) . "&size=200";
            $customer->qr_code = $qrUrl;
            $customer->save();

            // Generate Lucky Draw Coupon
            $couponCode = 'LD-' . strtoupper(substr(uniqid(), -6));
            Coupon::create([
                'coupon_code' => $couponCode,
                'customer_id' => $customer->id,
                'status' => 'active'
            ]);

            // Send WhatsApp with QR and Coupon
            $this->sendWhatsAppQR($customer, $couponCode);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer added successfully, QR & Coupon sent.'
                ]);
            }

            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer added successfully, QR & Coupon sent.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating customer: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()
                ->with('error', 'Error creating customer: ' . $e->getMessage())
                ->withInput();
        }
    }


    // Send WhatsApp QR + Coupon
    private function sendWhatsAppQR(Customer $customer, $couponCode = null)
    {
        $whatsAppApiUrl = 'https://graph.facebook.com/v17.0/<PHONE_NUMBER_ID>/messages';
        $accessToken = env('WHATSAPP_ACCESS_TOKEN');

        // Ensure mobile number has country code (India example)
        $mobileNumber = '91' . preg_replace('/[^0-9]/', '', $customer->mobile);

        $message = "Hello {$customer->name},\nYour QR Code is attached.\n";
        $message .= "Payment Status: {$customer->payment_status}\n";
        if ($customer->payment_link) {
            $message .= "Complete your payment here: {$customer->payment_link}\n";
        }
        $message .= "Use it for verification, check-in, or order reference.\n";
        if ($couponCode) {
            $message .= "Your Lucky Draw Coupon: {$couponCode}";
        }

        $data = [
            "messaging_product" => "whatsapp",
            "to" => $mobileNumber,
            "type" => "image",
            "image" => [
                "link" => $customer->qr_code, // URL, not base64
                "caption" => $message
            ]
        ];

        $ch = curl_init($whatsAppApiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            \Log::error("WhatsApp API Error: $error");
        }

        curl_close($ch);
        return $response;
    }


    // Scan QR (Payment Verification)
    public function scanQR($token)
    {
        $customer = Customer::where('token', $token)->firstOrFail();

        if ($customer->payment_status !== 'success') {
            return response()->json([
                'status' => 'pending',
                'message' => 'Payment not completed. Please complete payment to proceed.',
                'payment_link' => $customer->payment_link
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payment successful! QR is valid.',
            'customer' => $customer
        ]);
    }

    // Redeem Lucky Draw Coupon
    public function redeemCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|exists:coupons,coupon_code',
        ]);

        $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

        if ($coupon->status != 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Coupon already redeemed or expired.'
            ]);
        }

        $coupon->update([
            'status' => 'redeemed',
            'redeemed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon redeemed successfully!',
            'customer' => $coupon->customer
        ]);
    }
    // show dublicates value 
// List Duplicate Customers (by email or name)


    // Show edit form
    public function edit(Customer $customer)
    {
        $user = auth()->user();
        $schemes = Scheme::all();
        if ($user->role_id == 3 && $customer->agent_id != $user->id)
            abort(403);
        $agents = $user->role_id == 3 ? [] : User::where('role_id', 3)->get();
        return view('admin.customers.edit', compact('customer', 'agents', 'schemes'));
    }

    // Update customer
    public function update(Request $request, Customer $customer)
    {
        // dd($customer->id, $customer->email);

        $user = auth()->user();
        if ($user->role_id == 3 && $customer->agent_id != $user->id)
            abort(403);


        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customer->id) // 'id' likhne ki zarurat nahi
            ],

            'mobile' => [
                'required',
                'string',
                'max:15',
                Rule::unique('customers', 'mobile')->ignore($customer->id, 'id')
            ],

            'address' => 'nullable|string|max:500',
            'is_active' => 'required|boolean',
            'verification_status' => 'required|in:pending,approved,rejected',
            'agent_id' => 'nullable|exists:users,id',
            'payment_status' => 'nullable|in:pending,success,failed',
            'payment_link' => 'nullable|string|max:255',
            'scheme' => 'nullable|string|max:255'
        ]);


        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $agent_id = $user->role_id == 3 ? $customer->agent_id : $request->agent_id;

        $customer->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'is_active' => $request->is_active,
            'verification_status' => $request->verification_status,
            'agent_id' => $agent_id,
            'payment_status' => $request->payment_status ?? $customer->payment_status,
            'payment_link' => $request->payment_link ?? $customer->payment_link,
            'scheme' => $request->scheme ?? $customer->scheme,
            'scheme_id' => $request->scheme_id ?? null,
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
    }

    // Delete customer
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting customer: ' . $e->getMessage()
            ], 500);
        }
    }


    // Update verification status
    public function updateVerification(Request $request, Customer $customer)
    {
        $request->validate([
            'verification_status' => 'required|in:approved,rejected',
            'verification_notes' => 'nullable|string|max:1000',
        ]);

        $customer->update([
            'verification_status' => $request->verification_status,
            'verified_at' => $request->verification_status === 'approved' ? now() : null,
            'verification_notes' => $request->verification_notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Verification status updated successfully.'
        ]);
    }

    // Optional: Expire old coupons
    public static function expireCoupons()
    {
        Coupon::where('status', 'active')->where('created_at', '<', now()->subDays(30))
            ->update(['status' => 'expired']);
    }
}
