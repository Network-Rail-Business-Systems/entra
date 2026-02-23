<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Data;

class Users
{
    public static function make(): array
    {
        return [
            '@odata.context' => 'https://graph.microsoft.com/v1.0/$metadata#users',
            '@odata.nextLink' => 'https://graph.microsoft.com/v1.0/users',
            'value' => [
                [
                    'businessPhones' => [
                        '01234567890',
                    ],
                    'displayName' => 'Joe Bloggs',
                    'givenName' => 'Joe',
                    'jobTitle' => 'Business Systems Developer',
                    'mail' => 'Joe.Bloggs@networkrail.co.uk',
                    'mobilePhone' => '01234567890',
                    'officeLocation' => 'Some Office',
                    'preferredLanguage' => null,
                    'surname' => 'Bloggs',
                    'userPrincipalName' => 'JBloggs2@networkrail.co.uk',
                    'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
                ],
            ],
        ];
    }
}
