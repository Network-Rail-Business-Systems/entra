<?php

return [
    // These attributes will be synced on login, remove to disable keys
    // Keys are in Entra => Laravel format
    'sync_attributes' => [
        'businessPhones' => 'business_phone',
        'displayName' => 'name',
        'givenName' => 'first_name',
        'id' => 'azure_id',
        'jobTitle' => 'title',
        'mail' => 'email',
        'mobilePhone' => 'mobile_phone',
        'officeLocation' => 'office',
        'surname' => 'last_name',
        'userPrincipalName' => 'username',
    ],

    // The FQN of the Model to be used for Users
    'user_model' => 'App\Models\User',
];
