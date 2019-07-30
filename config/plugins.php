<?php

return [

    'plugins' => [

        'recaptcha' => [
            'public' => env('RECAPTCHA_SITE'),
            'secret' => env('RECAPTCHA_SECRET'),
        ],

    ]

];
