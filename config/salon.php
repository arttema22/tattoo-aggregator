<?php

return [
    'count_per_page' => 21,

    'review_per_page' => 10,

    'filters' => [
        'additional_service' => [
            4,
            2,
            6,
            5
        ]
    ],

    'nearby' => [
        'config' => [
            [
                'min_population' => 5000000,
                'distance' => 10000,
            ],
            [
                'min_population' => 750000,
                'distance' => 2500,
            ],
            [
                'min_population' => 350000,
                'distance' => 1500,
            ],
        ],

        'default_distance' => 1000,
        'count' => 3
    ]
];
