<?php

return [

    'enabled' => env('NEWS_FETCH_ENABLED', true),

    'default_country' => env('NEWS_DEFAULT_COUNTRY', 'ng'),

    'auto_publish' => env('NEWS_AUTO_PUBLISH', true),

    'fetch_interval' => env('NEWS_FETCH_INTERVAL', 3600),

    'api_keys' => [
        'newsdata' => env('NEWSDATA_API_KEY', ''),
        'guardian' => env('GUARDIAN_API_KEY', 'test'),
    ],

    'categories' => [
        'business',
        'technology',
        'entertainment',
        'health',
        'sports',
        'lifestyle',
        'politics',
        'culture',
    ],

];
