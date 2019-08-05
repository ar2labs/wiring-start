<?php

return [

    'connections' => [

        'doctrine' => [

            'driver' => env('DB_DRIVER', 'pdo_sqlite'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'path' => env('DB_DATABASE', 'storage/database.sqlite'),
            'dbname' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => env('DB_CHARSET'),

        ],

        'eloquent' => [

            'driver' => env('DB_DRIVER', 'pdo_sqlite'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'storage/database.sqlite'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',

        ],

    ],

];
