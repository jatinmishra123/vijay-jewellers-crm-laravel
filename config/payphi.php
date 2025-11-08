<?php
return [
    'env' => env('PAYPHI_ENV', 'sandbox'),

    // Direct URLs (तुम्हारे .env वाले)
    'sale_url' => env('PAYPHI_SALE_URL', 'https://qa.phicommerce.com/pg/api/v2/initiateSale'),
    'status_url' => env('PAYPHI_STATUS_URL', 'https://qa.phicommerce.com/pg/api/command'),
    'refund_url' => env('PAYPHI_REFUND_URL', 'https://qa.phicommerce.com/pg/api/command'),

    'merchant_id' => env('PAYPHI_MERCHANT_ID'),
    'hash_key' => env('PAYPHI_HASH_KEY'),

    // Optional: multiple merchants JSON (ना हो तो खाली रहने दो)
    'merchants' => env('PAYPHI_MERCHANTS_JSON', ''),

    // Return URL (ये भी .env में add कर लो)
    'return_url' => env('PAYPHI_RETURN_URL', env('APP_URL') . '/payphi/callback'),
];
