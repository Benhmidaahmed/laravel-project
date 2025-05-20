<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'utilisateurs'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'utilisateurs', // ✅ Use 'utilisateurs' instead of 'users'
        ],

        'api' => [
        'driver' => 'jwt', // Change from 'token' to 'jwt'
        'provider' => 'users',
    ],
    ],

    'providers' => [
        'utilisateurs' => [ // ✅ Custom provider name
            'driver' => 'eloquent',
            'model' => \App\Models\utilisateur::class, // ✅ Your actual model
        ],

        
    ],

    'passwords' => [
        'utilisateurs' => [ // ✅ Match the provider key
            'provider' => 'utilisateurs',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
