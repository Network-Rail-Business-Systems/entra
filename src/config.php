<?php

return [
    /** Whether to allow Users without an existing account to sign-in */
    'create_users' => true,

    /** Customise any error messages produced by Entra */
    'messages' => [
        'only_existing' => 'Only registered users are allowed to use this system; contact support for assistance',
    ],

    /**
     * These attributes will be synced on login, remove to disable keys
     * Keys are in Entra => Laravel format
     */
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

    /** The FQN of the Model to be used for Users */
    'user_model' => 'App\Models\User',

    /** Configure your local Entra emulator for tests and offline development */
    'emulator' => [
        /** Whether the emulator is enabled */
        'enabled' => false,

        /**
         * Which groups are available via the emulator
         * Each group should be an array of attributes which (at a minimum) have an ID, a mail, and member's mails
         */
        'groups' => [
            [
                'id' => '1',
                'mail' => 'fellowship@middle-earth.com',
                'members' => [
                    'gandalf.stormcrow@networkrail.co.uk',
                    'frodo.baggins@networkrail.co.uk',
                    'samwise.gamgee@networkrail.co.uk',
                    'aragorn.elessar@networkrail.co.uk',
                    'legolas.thranduil@networkrail.co.uk',
                    'gimli.gloin@networkrail.co.uk',
                    'boromir.denethor@networkrail.co.uk',
                    'merry.brandybuck@networkrail.co.uk',
                    'peregrin.took@networkrail.co.uk',
                ],
            ],
        ],

        /**
         * Which Users are available via the emulator
         * Each user should be an array of attributes which (at a minimum) match the sync_attributes
         */
        'users' => [
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Gandalf Stormcrow',
                'givenName' => 'Gandalf',
                'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'Wizard',
                'mail' => 'gandalf.stormcrow@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Minas Tirith',
                'surname' => 'Stormcrow',
                'userPrincipalName' => 'gandalf@networkrail.co.uk',
            ],
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Frodo Baggins',
                'givenName' => 'Frodo',
                'id' => '234ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'Ring Bearer',
                'mail' => 'frodo.baggins@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Bag End',
                'surname' => 'Baggins',
                'userPrincipalName' => 'frodo@networkrail.co.uk',
            ],
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Samwise Gamgee',
                'givenName' => 'Samwise',
                'id' => '345ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'Gardener',
                'mail' => 'samwise.gamgee@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'The Shire',
                'surname' => 'Gamgee',
                'userPrincipalName' => 'samwise@networkrail.co.uk',

            ],
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Aragorn Elessar',
                'givenName' => 'Aragorn',
                'id' => '456ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'King',
                'mail' => 'aragorn.elessar@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Minas Tirith',
                'surname' => 'Elessar',
                'userPrincipalName' => 'aragorn@networkrail.co.uk',
            ],
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Legolas Thranduil',
                'givenName' => 'Legolas',
                'id' => '567ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'Prince',
                'mail' => 'legolas.thranduil@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Mirkwood',
                'surname' => 'Thranduil',
                'userPrincipalName' => 'legolas@networkrail.co.uk',
            ],
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Gimli Gloin',
                'givenName' => 'Gimli',
                'id' => '678ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'Lord',
                'mail' => 'gimli.gloin@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Moria',
                'surname' => 'Gloin',
                'userPrincipalName' => 'gimli@networkrail.co.uk',
            ],
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Boromir Denethor',
                'givenName' => 'Boromir',
                'id' => '789ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'High Warden',
                'mail' => 'boromir.denethor@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Anduin',
                'surname' => 'Denethor',
                'userPrincipalName' => 'boromir@networkrail.co.uk',
            ],
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Merry Brandybuck',
                'givenName' => 'Merry',
                'id' => '890ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'Troublemaker',
                'mail' => 'Merry.Brandybuck@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Green Dragon Inn',
                'surname' => 'Brandybuck',
                'userPrincipalName' => 'merry@networkrail.co.uk',
            ],
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Peregrin Took',
                'givenName' => 'Peregrin',
                'id' => '901ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'Fool',
                'mail' => 'peregrin.took@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Green Dragon Inn',
                'surname' => 'Took',
                'userPrincipalName' => 'peregrin@networkrail.co.uk',
            ],
        ],
    ],
];
