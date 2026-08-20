<?php

return [
    'paystack' => [
        'secret_key' => env('PAYSTACK_SECRET_KEY', ''),
        'public_key' => env('PAYSTACK_PUBLIC_KEY', ''),
        'webhook_secret' => env('PAYSTACK_WEBHOOK_SECRET', ''),
    ],

    'monnify' => [
        'api_key' => env('MONNIFY_API_KEY', ''),
        'secret_key' => env('MONNIFY_SECRET_KEY', ''),
        'contract_code' => env('MONNIFY_CONTRACT_CODE', ''),
        'subaccount_code' => env('MONNIFY_SUBACCOUNT_CODE', ''),
    ],

    'nomba' => [
        'api_key' => env('NOMBA_API_KEY', ''),
        'secret_key' => env('NOMBA_SECRET_KEY', ''),
        'merchant_id' => env('NOMBA_MERCHANT_ID', ''),
        'webhook_secret' => env('NOMBA_WEBHOOK_SECRET', ''),
    ],
];
