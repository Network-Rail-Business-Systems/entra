<?php

return [
    'client' => env('ENTRA_CLIENT'),
    'proxy' => env('ENTRA_PROXY'),
    'scopes' => env('ENTRA_SCOPES', 'User.Read.All offline_access Group.Read.All'),
    'secret' => env('ENTRA_SECRET'),
    'tenant' => env('ENTRA_TENANT'),
];
