<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PayPhiService
{
    /* ---------- URLs (तुम्हारे .env वाले keys से) ---------- */
    protected function saleUrl(): string
    {
        // config/payphi.php हो तो पहले वही पढ़ेगा, नहीं तो सीधे .env
        return config('payphi.sale_url', env('PAYPHI_SALE_URL', 'https://qa.phicommerce.com/pg/api/v2/initiateSale'));
    }

    protected function statusUrl(): string
    {
        return config('payphi.status_url', env('PAYPHI_STATUS_URL', 'https://qa.phicommerce.com/pg/api/command'));
    }

    /* ---------- Merchant/Key resolve (single + multi merchant दोनों) ---------- */
    public function resolveMerchant(?string $checkoutMerchantId = null): array
    {
        // default single merchant (.env)
        $merchantId = config('payphi.merchant_id', env('PAYPHI_MERCHANT_ID'));
        $hashKey = config('payphi.hash_key', env('PAYPHI_HASH_KEY'));

        $listJson = config('payphi.merchants', env('PAYPHI_MERCHANTS_JSON', ''));
        if (!$checkoutMerchantId || empty($listJson)) {
            return ['merchantId' => $merchantId, 'hashKey' => $hashKey];
        }

        $list = json_decode($listJson, true) ?: [];
        foreach ($list as $row) {
            if (($row['merchId'] ?? null) === $checkoutMerchantId) {
                return ['merchantId' => $row['merchId'], 'hashKey' => $row['hashKey']];
            }
        }
        return ['merchantId' => $merchantId, 'hashKey' => $hashKey];
    }

    /* ---------- Common helpers ---------- */
    public function nowTxnDate(): string
    {
        // PayPhi txnDate format: YmdHis
        return now()->format('YmdHis');
    }

    /**
     * Initiate hash बनाना (SALE)
     * message order (concat बिना सेपरेटर):
     * amount + currencyCode + customerEmailID + customerMobileNo + customerName +
     * merchantId + merchantTxnNo + payType + returnURL + transactionType + txnDate + <hashKey>
     */
    public function makeInitiateHash(array $p, string $hashKey): string
    {
        $msg =
            ($p['amount'] ?? '') .
            ($p['currencyCode'] ?? '') .
            ($p['customerEmailID'] ?? '') .
            ($p['customerMobileNo'] ?? '') .
            ($p['customerName'] ?? '') .
            ($p['merchantId'] ?? '') .
            ($p['merchantTxnNo'] ?? '') .
            ($p['payType'] ?? '') .
            ($p['returnURL'] ?? '') .
            ($p['transactionType'] ?? '') .
            ($p['txnDate'] ?? '') .
            $hashKey;

        return hash('sha256', $msg);
    }

    /**
     * Status hash (COMMAND: STATUS/REFUND आदि)
     * amount + merchantId + merchantTxnNo + originalTxnNo + transactionType + <hashKey>
     */
    public function makeStatusHash(array $p, string $hashKey): string
    {
        $msg =
            ($p['amount'] ?? '') .
            ($p['merchantId'] ?? '') .
            ($p['merchantTxnNo'] ?? '') .
            ($p['originalTxnNo'] ?? '') .
            ($p['transactionType'] ?? '') .
            $hashKey;

        return hash('sha256', $msg);
    }

    /* ---------- HTTP calls ---------- */
    public function initiateSale(array $payload): array
    {
        // कुछ सेटअप JSON लेते हैं; ज़रूरत पर ->post($url, $payload) use करो
        $res = Http::timeout(30)->asForm()->post($this->saleUrl(), $payload);
        return $res->json() ?? [];
    }

    public function statusCommand(array $payload): array
    {
        $res = Http::timeout(30)->asForm()->post($this->statusUrl(), $payload);
        return $res->json() ?? [];
    }
}
