<?php

return [

   

    'whatsapp' => [
        'api_key' => env('WHATSAPP_API_KEY'),
        'api_url' => env('WHATSAPP_API_URL'),
        'contact_number' => env('WHATSAPP_CONTACT_NUMBER'),
    ],

    'sms' => [
        'contact_number' => env('SMS_CONTACT_NUMBER'),
    ],

    'ussd' => [
        'code' => env('USSD_CODE', '*150*00#'),
    ],

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

 'pesapal' => [
    'consumer_key' => env('PESAPAL_CONSUMER_KEY'),
    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),
    'env' => env('PESAPAL_ENV', 'sandbox'),
    'base_url' => 'https://pay.pesapal.com/v3/api',
    'callback_url' => env('PESAPAL_CALLBACK_URL'),
],
];
