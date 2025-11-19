<?php

return [
    'commission' => [
        'default_rate' => 10, // 10%
        'min_rate' => 5,
        'max_rate' => 20,
    ],
    'promoter' => [
        'auto_approve' => false,
        'required_documents' => ['identification'],
    ],
    'booking' => [
        'min_duration' => 1,
        'max_duration_days' => 365,
    ],
    'payment' => [
        'methods' => ['mobile_money', 'card', 'cash', 'bank_transfer'],
        'providers' => [
            'mobile_money' => ['mobicash', 'orange_money', 'moov_money'],
            'card' => ['visa', 'mastercard'],
        ],
    ],
];


