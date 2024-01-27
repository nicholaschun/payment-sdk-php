<?php

return [
  'paystack' => [
    'ghana' => [
      'base_url' => env('PAYSTACK_BASE_URL', 'https://api.paystack.co'),
      'secret_key' => env('PAYSTACK_SECRET_KEY_GH', 'sk_test_ffa6d1d1845199837744ac56658ad8313c8ec718'),
      'charge' => env('PAYSTACK_CHARGE_GH', 0.00)
    ],
    'nigeria' => [
      'base_url' => env('PAYSTACK_BASE_URL', 'https://api.paystack.co'),
      'secret_key' => env('PAYSTACK_SECRET_KEY_NG', 'sk_test_ffa6d1d1845199837744ac56658ad8313c8ec718NG'),
      'charge' => env('PAYSTACK_CHARGE_NG', 0.00)

    ],
  ]
];