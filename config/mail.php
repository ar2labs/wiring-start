<?php

return [

    'mail' => [

        'driver' => env('MAIL_DRIVER', 'smtp'),
        'host' => env('MAIL_HOST', 'smtp.googlemail.com'),
        'port' => env('MAIL_PORT', 587),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
        'from.name' => env('MAIL_FROM_NAME', 'noreply'),
        'from' => env('MAIL_FROM', 'noreply@example.com'),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    ]

];
