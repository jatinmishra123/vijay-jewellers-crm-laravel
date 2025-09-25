<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mail Services
    |--------------------------------------------------------------------------
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Slack Notifications
    |--------------------------------------------------------------------------
    */

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Twilio (SMS / WhatsApp)
    |--------------------------------------------------------------------------
    */

    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from' => env('TWILIO_WHATSAPP_FROM'),
        'admin_number' => env('TWILIO_ADMIN_NUMBER'),
    ],

    /*
    |--------------------------------------------------------------------------
    | PayPhi Payment Gateway
    |--------------------------------------------------------------------------
    */

    'payphi' => [
        'sale_url' => env('PAYPHI_SALE_URL'),
        'status_url' => env('PAYPHI_STATUS_URL'),
        'refund_url' => env('PAYPHI_REFUND_URL'),
        'merchant_id' => env('PAYPHI_MERCHANT_ID'),
        'hash_key' => env('PAYPHI_HASH_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | WordPress API
    |--------------------------------------------------------------------------
    */

    'wp' => [
        'api_url' => env('WP_API_URL'),
        'username' => env('WP_USER'),
        'app_password' => env('WP_APP_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | WooCommerce API
    |--------------------------------------------------------------------------
    */

    'woocommerce' => [
        'url' => env('WC_STORE_URL'),
        'key' => env('WC_CONSUMER_KEY'),
        'secret' => env('WC_CONSUMER_SECRET'),
    ],

];
