<?php

return [
    'consumer_key' => env('MPESA_CONSUMER_KEY', ''),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET', ''),
    'token_url' => env('MPESA_TOKEN_URL', ''),
    'stkpush_url' => env('MPESA_STKPUSH_URL', ''),
    'passkey' => env('MPESA_PASSKEY', ''),
    'shortcode' => env('MPESA_SHORTCODE', ''),
    'settings' => array(
        'mode' => env('MPESA_EXPRESS', ''),
        'Http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/mpesa.log',
        'log.LogLevel' => 'ERROR',
    ),
];