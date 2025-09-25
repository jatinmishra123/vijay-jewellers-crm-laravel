<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['customer', 'sale'])
            ->orderBy('payment_date', 'desc')
            ->get();

        $todayPayments = $payments->where('payment_date', now()->format('Y-m-d'));

        $summary = [
            'total_today' => $todayPayments->count(),
            'successful' => $todayPayments->where('status', 'Successful')->count(),
            'failed' => $todayPayments->where('status', 'Failed')->count(),
            'pending' => $todayPayments->where('status', 'Pending')->count(),
            'by_method' => $todayPayments->groupBy('method')->map->count()->toArray(),
        ];

        return view('payments.index', compact('payments', 'summary'));
    }

    // ✅ PayPhi Payment Initiation
    public function initiatePayment(Request $request)
    {
        $url = "https://qa.phicommerce.com/pg/api/v2/initiateSale"; // Sandbox
        $merchantId = "YOUR_MERCHANT_ID";
        $hashKey = "YOUR_HASH_KEY";

        $payload = [
            "merchantId" => $merchantId,
            "orderId" => "ORDER_" . time(),
            "amount" => $request->amount,
            "currency" => "INR",
            "redirectUrl" => route('payments.callback'),
            "customer" => [
                "name" => $request->customer_name,
                "email" => $request->customer_email,
                "phone" => $request->customer_phone
            ]
        ];

        // Hash generate
        $payloadString = json_encode($payload);
        $signature = hash_hmac('sha256', $payloadString, $hashKey);

        // API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'signature' => $signature
        ])->post($url, $payload);

        $res = $response->json();

        // Agar API success hai, payment record save karo
        if (!empty($res['paymentUrl'])) {
            Payment::create([
                'customer_id' => $request->customer_id,
                'sale_id' => $request->sale_id,
                'amount' => $request->amount,
                'method' => 'PayPhi',
                'status' => 'Pending',
                'payment_date' => now(),
                'transaction_id' => $payload['orderId']
            ]);

            return redirect()->away($res['paymentUrl']); // User ko PayPhi payment page par bhejo
        }

        return back()->with('error', 'Payment initiation failed.');
    }

    // ✅ Callback (PayPhi response receive)
    public function paymentCallback(Request $request)
    {
        $data = $request->all();

        // Find payment record
        $payment = Payment::where('transaction_id', $data['orderId'])->first();

        if ($payment) {
            $payment->status = $data['status'] == 'SUCCESS' ? 'Successful' : 'Failed';
            $payment->save();
        }

        return view('payments.callback', compact('data'));
    }

    public function export($type)
    {
        $fileName = 'payments_' . date('Ymd_His') . '.' . $type;

        if ($type == 'csv') {
            return Excel::download(new PaymentsExport, $fileName, \Maatwebsite\Excel\Excel::CSV);
        } else if ($type == 'excel') {
            return Excel::download(new PaymentsExport, $fileName, \Maatwebsite\Excel\Excel::XLSX);
        }
    }
}
