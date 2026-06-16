<?php

use App\Models\User;

return [


    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        // Guard default untuk warga
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        // Guard khusus untuk admin
        'admin' => [
            'driver'   => 'session',
            'provider' => 'admin_users',
        ],
    ],

    'providers' => [
        // Provider untuk warga (tabel users)
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],

        // Provider untuk admin (tabel admin_users)
        'admin_users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\AdminUser::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];