<?php

return [

    'displayErrorDetails' => env('APP_DEBUG', false),

    'timezone' => 'America/Sao_Paulo',

    'database' => env('DB_CONNECTION', 'eloquent'),

    'auth' => env('API_AUTH', 'jwt'),

];
