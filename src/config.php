<?php

return [
    'models' => [
        'user' => 'App\Models\User',
    ],

    'client' => env('ENTRA_CLIENT'),
    'proxy' => env('ENTRA_PROXY'),
    'scopes' => env('ENTRA_SCOPES', 'User.Read.All offline_access Group.Read.All'),
    'secret' => env('ENTRA_SECRET'),
    'tenant' => env('ENTRA_TENANT'),

    /* Emulator options - remove after publishing */
    'emulator' => [
        'enabled' => env('ENTRA_DEBUG', false),
        'id' => env('ENTRA_EMULATOR_ID', null),
    ],
];
