<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
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

    // 🔥 FIREBASE
    'firebase' => [
        'credentials' => env('FIREBASE_CREDENTIALS'),
    ],

    // 📲 TWILIO
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from_phone' => env('TWILIO_FROM_PHONE'),
        'verification_message_template' =>
            'Tu código de verificación es %s',
    ],

    'other-project' => [
        'base_url' => env('OTHER_PROJECT_BASE_URL'),
        'email' => env('OTHER_PROJECT_EMAIL'),
        'password' => env('OTHER_PROJECT_PASSWORD'),
        'partner_key' => env('OTHER_PROJECT_PARTNER_KEY'),
        'token_ttl_days' => 180, // 6 meses
    ],

];
