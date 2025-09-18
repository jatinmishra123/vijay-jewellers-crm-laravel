<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayphiController extends Controller
{
    public function showCheckout()
    {
        return view('payphi_checkout');
    }

    public function initiatePayment(Request $request)
    {
        // validate input
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'customer_name' => 'nullable|string',
            'customer_email' => 'nullable|email',
            'customer_mobile' => 'nullable|string'
        ]);

        // env values
        $merchantId = env('PAYPHI_MERCHANT_ID');
        $aggregatorId = env('PAYPHI_AGGREGATOR_ID'); // optional
        $hashKey = env('PAYPHI_HASH_KEY');
        $saleUrl = env('PAYPHI_SALE_URL');

        Log::debug('PayPhi ENV values', [
            'merchantId' => $merchantId,
            'aggregatorId' => $aggregatorId,
            'hashKey_set' => $hashKey ? true : false,
            'saleUrl' => $saleUrl,
        ]);

        // aggregatorId optional है, इसलिए check से हटा दिया
        if (empty($merchantId) || empty($hashKey) || empty($saleUrl)) {
            Log::error('PayPhi ENV missing', compact('merchantId', 'aggregatorId', 'hashKey', 'saleUrl'));
            return back()->with('error', 'PayPhi configuration missing in .env file.');
        }

        $merchantTxnNo = time() . rand(1000, 9999);

        $payload = [
            'merchId' => $merchantId,
            'merchantTxnNo' => $merchantTxnNo,
            'amount' => number_format($data['amount'], 2, '.', ''),
            'currency' => 'INR',
            'returnUrl' => route('payphi.callback'),
            'customerName' => $data['customer_name'] ?? '',
            'customerEmail' => $data['customer_email'] ?? '',
            'customerMobile' => $data['customer_mobile'] ?? '',
        ];

        // सिर्फ तब जोड़ें जब aggregatorId env में दिया हो
        if (!empty($aggregatorId)) {
            $payload['aggregatorId'] = $aggregatorId;
        }

        // secure hash generate करें
        $message = $payload['merchId'] . '|' . $payload['merchantTxnNo'] . '|' . $payload['amount'];
        $payload['secureHash'] = hash_hmac('sha256', $message, $hashKey);

        Log::debug('PayPhi Payload Prepared', $payload);

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post($saleUrl, $payload);

            Log::debug('PayPhi API HTTP Info', [
                'status' => $response->status(),
                'headers' => $response->headers()
            ]);
            Log::debug('PayPhi API Raw Body', ['body' => $response->body()]);

            $resp = $response->json();

            Log::info('PayPhi API Parsed Response', ['resp' => $resp]);

            if (isset($resp['paymentUrl'])) {
                return redirect()->away($resp['paymentUrl']);
            }

            if (isset($resp['paymentPageHtml'])) {
                return response($resp['paymentPageHtml']);
            }

            return response()->json([
                'status' => 'unknown_response',
                'response' => $resp
            ]);

        } catch (\Exception $e) {
            Log::error('PayPhi initiate exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    public function paymentCallback(Request $request)
    {
        $all = $request->all();
        Log::info('PayPhi callback received', ['data' => $all]);

        if (isset($all['secureHash'])) {
            $hashKey = env('PAYPHI_HASH_KEY');
            $message = ($all['merchId'] ?? '') . '|' . ($all['merchantTxnNo'] ?? '') . '|' . ($all['amount'] ?? '');
            $computed = hash_hmac('sha256', $message, $hashKey);

            Log::debug('PayPhi Callback Hash Debug', [
                'message' => $message,
                'computed' => $computed,
                'received' => $all['secureHash']
            ]);

            if (hash_equals($computed, $all['secureHash'])) {
                $status = $all['status'] ?? ($all['txnStatus'] ?? 'UNKNOWN');
                if (strtoupper($status) === 'SUCCESS') {
                    Log::info('PayPhi Payment SUCCESS', ['txn' => $all]);
                    return view('payphi_success', ['data' => $all]);
                } else {
                    Log::warning('PayPhi Payment Not Success', [
                        'status' => $status,
                        'txn' => $all
                    ]);
                }
            } else {
                Log::warning('PayPhi callback signature mismatch', [
                    'expected' => $computed,
                    'received' => $all['secureHash']
                ]);
                return response('Invalid signature', 400);
            }
        }

        return view('payphi_failure', ['data' => $all]);
    }
}
