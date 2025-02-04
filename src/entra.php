<?php

return [
    // Entra => Laravel
    'sync_attributes' => [
        "displayName" => "name",
        "givenName" => "first_name",
        "jobTitle" => "title",
        "mail" => "email",
        "mobilePhone" => "phone",
        "officeLocation" => "office",
        "surname" => "last_name",
        "userPrincipalName" => "username",
        "id" => "azure_id",
    ],

    // The FQN of the Model to be used for Users
    'user_model' => 'App\Models\User',
];
