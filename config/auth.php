<?php

return [

    // 'defaults' => [
    //     // 'guard' => env('AUTH_GUARD', 'web'),
    //     'guard' => env('AUTH_GUARD', 'customer'),
    //     // 'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    //     'passwords' => env('AUTH_PASSWORD_BROKER', 'customer'),
    // ],

    'defaults' => [
        'guard' => 'customer',
        'passwords' => 'customer',
    ],

    'guards' => [
        // 'web' => [
        //     'driver' => 'session',
        //     'provider' => 'admins',
        // ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'customer' => [
            'driver' => 'session',
            'provider' => 'customer',
        ],
    ],

    'providers' => [
        'admins' => [ // Provider untuk model Admin
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'customer' => [
            'driver' => 'eloquent',
            // 'model' => env('AUTH_MODEL', App\Models\User::class),
            'model' => App\Models\Customer::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    // 'passwords' => [
    //     'users' => [
    //         'provider' => 'users',
    //         'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
    //         'expire' => 60,
    //         'throttle' => 60,
    //     ],
    // ],

    'passwords' => [
        'customer' => [
            'provider' => 'customer',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
