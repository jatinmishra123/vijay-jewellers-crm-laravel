<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PayphiController extends Controller
{
    /**
     * 🧾 Show checkout form
     */
    public function showCheckout()
    {
        return view('payphi_checkout');
    }

    /**
     * 💳 Initiate Payment (Final UAT Verified Version - HMAC FIXED)
     */
    public function initiatePayment(Request $request)
    {
        try {
            // ✅ Validate inputs
            $data = $request->validate([
                'amount' => 'required|numeric|min:1',
                'customer_email' => 'required|email|max:150',
                'customer_mobile' => 'required|string|max:15',
            ]);

            // ✅ Load PayPhi configuration
            $merchantId = env('PAYPHI_MERCHANT_ID');
            $hashKey = env('PAYPHI_HASH_KEY');
            $saleUrl = env('PAYPHI_SALE_URL');
            $returnUrl = env('PAYPHI_RETURN_URL');

            if (!$merchantId || !$hashKey || !$saleUrl || !$returnUrl) {
                throw new \Exception('Missing PayPhi configuration in .env');
            }

            // ✅ Generate unique txn details
            $merchantTxnNo = now()->format('dmYHis') . rand(100, 999);
            $txnDate = now()->format('YmdHis');

            // ✅ Prepare payload
            $payload = [
                "merchantId" => $merchantId,
                "merchantTxnNo" => $merchantTxnNo,
                "amount" => number_format($data['amount'], 2, '.', ''),
                "currencyCode" => "356",
                "payType" => "0",
                "paymentMode" => "nb",
                "allowDisablePaymentMode" => "nb",
                "paymentOptionCodes" => "ATOM",
                "customerEmailID" => $data['customer_email'],
                "transactionType" => "SALE",
                "txnDate" => $txnDate,
                "returnURL" => $returnUrl,
                "customerMobileNo" => $data['customer_mobile'],
                "addlParam1" => "Test1",
                "addlParam2" => "Test2",
            ];

            /**
             * ✅ PayPhi v2 Official Hash Sequence (Updated)
             * 1. Sort parameters alphabetically (A-Z)
             * 2. Concatenate non-empty values
             * 3. Apply HMAC-SHA256 using secret key
             */
            $sortedPayload = $payload;
            ksort($sortedPayload);

            $hashString = '';
            foreach ($sortedPayload as $key => $value) {
                if (!is_null($value) && $value !== '') {
                    $hashString .= $value;
                }
            }

            $payload['secureHash'] = strtolower(hash_hmac('sha256', $hashString, $hashKey));

            Log::info('✅ PayPhi Payload Prepared', [
                'payload' => $payload,
                'hash_string' => $hashString,
            ]);

            // ✅ Send API request to PayPhi
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withOptions(['verify' => false])
                ->timeout(60)
                ->post($saleUrl, $payload);

            Log::info('💬 PayPhi Response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            // ✅ Handle PayPhi Response
            if ($response->successful()) {
                $res = $response->json();

                if (
                    isset($res['responseCode']) &&
                    $res['responseCode'] === 'R1000' &&
                    !empty($res['redirectURI']) &&
                    !empty($res['tranCtx'])
                ) {
                    $redirectUrl = $res['redirectURI'] . '?tranCtx=' . $res['tranCtx'];
                    Log::info('🌐 Redirecting to PayPhi Gateway', ['url' => $redirectUrl]);
                    return redirect()->away($redirectUrl);
                }

                return back()->with('info', 'Unexpected PayPhi response: ' . json_encode($res));
            }

            throw new \Exception('HTTP ' . $response->status() . ': ' . $response->body());
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('❌ PayPhi initiate exception', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * 🔁 Callback from PayPhi (UAT verified)
     */
    /**
     * 🔁 Callback from PayPhi (UAT verified) - FIXED VERSION
     */
    public function paymentCallback(Request $request)
    {
        \Log::info('🎯 CALLBACK STARTED ==================');
        \Log::info('📥 PayPhi Callback Received', [
            'method' => $request->method(),
            'all_data' => $request->all(),
            'headers' => $request->headers->all(),
            'ip' => $request->ip()
        ]);

        // ... rest of your code

        \Log::info('🎯 CALLBACK COMPLETED ==================');
    }




}
