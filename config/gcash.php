<?php

return [
    'api_base_url' => env('GCASH_API_BASE_URL', 'https://g.payx.ph/payment_request'),
    'webhooksuccessurl' => env('GCASH_WEBHOOK_SUCCESS_URL'),
    'webhookfailurl' => env('GCASH_WEBHOOK_FAIL_URL'),
    'public_key' => env('GCASH_PUBLIC_KEY'),
    'link_expiry' => env('GCASH_LINK_EXPIRY'),
];