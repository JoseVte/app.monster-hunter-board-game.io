<?php

return [
    'users' => [
        'admin' => [
            'name' => env('ADMIN_NAME'),
            'email' => env('ADMIN_EMAIL'),
            'password' => env('ADMIN_PASSWORD'),
        ],
    ],

    'muscular-zone-themes' => [
        'Espalda' => 'red',
        'Pecho' => 'yellow',
        'Piernas' => 'pink',
        'Abdominales' => 'green',
        'Lumbares' => 'purple',
        'Hombros' => 'indigo',
        'Biceps' => 'tan',
        'Triceps' => 'teal',
    ],
];
