<?php

return [
    'payments' => [
        'default' => env('BLOSSOM_PAYMENT_DEFAULT', 'paystack'),
        'fallback_order' => ['paystack', 'monnify', 'nomba'],
    ],

    'subscriptions' => [
        'plans' => [
            'monthly' => [
                'name' => 'Insider Monthly',
                'price' => 2500,
                'currency' => 'NGN',
                'interval' => 'monthly',
            ],
            'yearly' => [
                'name' => 'Patron Annual',
                'price' => 20000,
                'currency' => 'NGN',
                'interval' => 'yearly',
            ],
        ],
    ],

    'listings' => [
        'tiers' => [
            'standard' => [
                'name' => 'Standard',
                'price' => 0,
                'features' => ['Basic listing', '1 listing per month'],
            ],
            'featured' => [
                'name' => 'Featured',
                'price' => 15000,
                'currency' => 'NGN',
                'interval' => 'monthly',
                'features' => ['Featured placement', '5 listings', 'Priority support'],
            ],
            'premium' => [
                'name' => 'Premium',
                'price' => 35000,
                'currency' => 'NGN',
                'interval' => 'monthly',
                'features' => ['Top placement', 'Unlimited listings', 'Premium badge', 'Dedicated support'],
            ],
        ],
    ],

    'newsletter' => [
        'broadcast_enabled' => true,
        'batch_size' => 50,
    ],
];
