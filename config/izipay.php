<?php

return [
    'environment' => env('IZIPAY_ENV', 'sandbox'),

    'endpoint' => env('IZIPAY_ENDPOINT', 'https://api.micuentaweb.pe'),

    'username' => env('IZIPAY_USERNAME', ''),

    'password' => env('IZIPAY_PASSWORD', ''),

    'public_key' => env('IZIPAY_PUBLIC_KEY', ''),

    'sha256_key' => env('IZIPAY_SHA256_KEY', ''),

    'whatsapp_phone' => env('WHATSAPP_PHONE', '51950883155'),
];
