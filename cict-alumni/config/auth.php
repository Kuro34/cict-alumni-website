<?php

return [

    'defaults' => [
        'guard' => 'alumni', // Set alumni as default guard
        'passwords' => 'alumni',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'alumni' => [ // Alumni guard
            'driver' => 'session',
            'provider' => 'alumni',
        ],

        'admin' => [ // Admin guard
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'alumni' => [ // Alumni provider
            'driver' => 'eloquent',
            'model' => App\Models\Alumni::class,
        ],

        'admins' => [ // Admin provider
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'alumni' => [
            'provider' => 'alumni',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
