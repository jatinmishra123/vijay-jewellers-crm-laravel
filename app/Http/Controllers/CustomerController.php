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
        $query = Customer::with(['agent', 'scheme']);

        if ($user->role_id == 3) {
            $query->where('agent_id', $user->id);
        }

        if ($request->filled('scheme_id')) {
            $query->where('scheme_id', $request->scheme_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('mtoken', 'like', "%{$search}%");
            });
        }

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

        $customers = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'today_new' => Customer::whereDate('created_at', today())->count(),
            'active_count' => Customer::where('is_active', 1)->count(),
            'inactive_pending_count' => Customer::where(function ($q) {
                $q->where('is_active', 0)
                    ->orWhere('verification_status', 'pending');
            })->count(),
        ];

        $schemes = Scheme::all();

        if ($request->ajax()) {
            $table = view('admin.customers.partials.table', compact('customers'))->render();
            $pagination = view('admin.customers.partials.pagination', compact('customers'))->render();

            return response()->json([
                'table' => $table,
                'pagination' => $pagination,
                'stats' => $stats
            ]);
        }

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

    // ✅ Store (with Auto Payment Link)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'mobile' => 'required|string|max:15|unique:customers,mobile',
            'address' => 'required|string|max:500',
            'is_active' => 'required|boolean',
            'agent_id' => 'nullable|exists:users,id',
            'scheme_id' => 'required|exists:schemes,id',
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

        // ✅ Check duplicate MToken in same scheme
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
                'scheme' => $request->scheme ?? 'Not Provided',
                'scheme_id' => $request->scheme_id
            ]);

            // ✅ Step 1: Generate Payment Link Automatically
            $amount = number_format($request->scheme_total_amount ?? 0, 2, '.', '');
            $baseUrl = url('/payphi/checkout');
            $query = http_build_query([
                'amount' => $amount,
                'customer_email' => $customer->email ?? '',
                'customer_mobile' => $customer->mobile,
                'customer_id' => $customer->id,
            ]);
            $paymentLink = "{$baseUrl}?{$query}";

            $customer->update(['payment_link' => $paymentLink]);

            // ✅ Step 2: Generate QR code
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
            // ✅ Step 2: Generate scannable QR (QuickChart – direct payment link)
            $qrUrl = 'https://quickchart.io/qr?text=' . urlencode($paymentLink) . '&size=250&margin=2';
            $customer->qr_code = $qrUrl;
            $customer->save();


            // ✅ Step 3: Generate Lucky Draw Coupon
            $couponCode = 'LD-' . strtoupper(substr(uniqid(), -6));
            Coupon::create([
                'coupon_code' => $couponCode,
                'customer_id' => $customer->id,
                'status' => 'active'
            ]);

            // ✅ Step 4: Send WhatsApp
            $this->sendWhatsAppQR($customer, $couponCode);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer added successfully. Payment link generated & QR sent!',
                    'payment_link' => $paymentLink
                ]);
            }

            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer added successfully. Payment link generated & QR sent!');

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
        try {
            $webhookUrl = 'https://webhook.whatapi.in/webhook/68c2b5570686f623b6e36d29';

            // ✅ नंबर formatting (India)
            $mobileNumber = preg_replace('/[^0-9]/', '', $customer->mobile);
            if (strlen($mobileNumber) == 10) {
                $mobileNumber = '91' . $mobileNumber;
            }

            // ✅ WhatsApp Message Content
            $message = "👋 *Hello {$customer->name}*,\n\n";
            $message .= "Your registration with *Vijay Jewellers* is successful ✅\n\n";
            $message .= "📋 *Scheme:* {$customer->scheme}\n";
            $message .= "💰 *Total Amount:* ₹{$customer->scheme_total_amount}\n";
            $message .= "📱 *Mobile:* {$customer->mobile}\n\n";
            $message .= "💳 *Payment Link:* {$customer->payment_link}\n\n";
            $message .= "📸 Scan this QR to pay or show at counter.\n";
            if ($couponCode) {
                $message .= "\n🎟️ *Lucky Draw Coupon:* {$couponCode}\n";
            }
            $message .= "\n_Thank you for choosing Vijay Jewellers._ 💎";

            // ✅ WhatAPI Payload
            $payload = [
                "receiverMobileNo" => $mobileNumber,
                "messageType" => "image",
                "message" => $message,
                "fileUrl" => $customer->qr_code,
                "fileName" => "vijay_jewellers_qr.png"
            ];

            // ✅ CURL Request
            $ch = curl_init($webhookUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($ch);

            if ($response === false) {
                $error = curl_error($ch);
                \Log::error('❌ WhatsApp Send Failed', ['error' => $error]);
            }

            curl_close($ch);

            // ✅ Log success or fail
            \Log::info('📤 WhatsApp Message Sent', [
                'to' => $mobileNumber,
                'payload' => $payload,
                'response' => $response,
            ]);

            return $response;
        } catch (\Exception $e) {
            \Log::error('❌ WhatsApp Send Exception', ['error' => $e->getMessage()]);
            return false;
        }
    }



    // Scan QR
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

    // Edit
    public function edit(Customer $customer)
    {
        $user = auth()->user();
        $schemes = Scheme::all();
        if ($user->role_id == 3 && $customer->agent_id != $user->id)
            abort(403);
        $agents = $user->role_id == 3 ? [] : User::where('role_id', 3)->get();
        return view('admin.customers.edit', compact('customer', 'agents', 'schemes'));
    }

    // Update
    public function update(Request $request, Customer $customer)
    {
        $user = auth()->user();

        if ($user->role_id == 3 && $customer->agent_id != $user->id)
            abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customer->id, 'id')
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
            'scheme_id' => 'nullable|exists:schemes,id',
        ]);

        $agent_id = $user->role_id == 3 ? $customer->agent_id : $request->agent_id;

        // ✅ Step 1: Update customer data
        $customer->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'is_active' => $request->is_active,
            'verification_status' => $request->verification_status,
            'agent_id' => $agent_id,
            'payment_status' => $request->payment_status ?? $customer->payment_status,
            'scheme_id' => $request->scheme_id ?? $customer->scheme_id,
        ]);

        // ✅ Step 2: Generate/refresh PayPhi payment link
        $paymentLink = route('payphi.checkout', [
            'amount' => $customer->scheme->total_amount ?? 0,
            'customer_email' => $customer->email ?? '',
            'customer_mobile' => $customer->mobile ?? '',
            'customer_id' => $customer->id,
        ]);

        // ✅ Step 3: Save generated link in DB
        $customer->update(['payment_link' => $paymentLink]);

        // ✅ Step 4: AJAX Support (Edit page JS ke liye)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Customer updated successfully!',
                'payment_link' => $paymentLink,
            ]);
        }

        // ✅ Step 5: Normal redirect (agar non-AJAX hai)
        return redirect()->route('admin.customers.edit', $customer->id)
            ->with('success', 'Customer updated successfully!')
            ->with('payment_link', $paymentLink);
    }


    public function destroy(Customer $customer)
    {
        try {
            \App\Models\SchemeMember::where('customer_id', $customer->id)->delete();
            $customer->delete();

            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Error deleting customer: ' . $e->getMessage());
        }
    }

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

    public static function expireCoupons()
    {
        Coupon::where('status', 'active')->where('created_at', '<', now()->subDays(30))
            ->update(['status' => 'expired']);
    }
}
