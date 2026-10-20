<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        'api/*',               // Todas tus rutas API
        'sanctum/csrf-cookie', // Necesario para Sanctum
        '!my-project/webhook',    // Excluye webhook del proyecto que corresponda
    ],

    'allowed_methods' => [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
        'OPTIONS',  // Necesario para preflight
    ],

    'allowed_origins' => explode(',', env('ALLOWED_ORIGINS', '')),

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'Authorization',
        'Content-Type',
        'Accept',
        'z-key-type',
        'X-Requested-With',
        'Cache-Control',
        'X-Client-Type',
        'X-Mobile-App-Key',
        'X-Postman-Key',
        'X-Request-Encrypted',
        'X-Response-Encrypted',
        'X-Client-Public-Key',
        'X-Temp-Public-Key',
    ],

    'exposed_headers' => [
        'Authorization', //tokens en headers
        'X-RateLimit-Remaining', //para uso de rate limiting
        'X-Response-Encrypted',
        'X-Encryption-Version',
    ],

    'max_age' => 86400,

    'supports_credentials' => false, //Pasar a true si a futuro se usa login con cookie csrf

];
