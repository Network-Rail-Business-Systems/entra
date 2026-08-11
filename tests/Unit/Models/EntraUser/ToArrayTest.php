<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ToArrayTest extends TestCase
{
    public function test(): void
    {
        $user = new EntraUser(
            'abc123',
            'jbloggs@networkrail.co.uk',
            'joe.bloggs@networkrail.co.uk',
            'Joe Bloggs',
            'Joe',
            'Bloggs',
            'Developer',
            'Milton Keynes',
            ['01234567890'],
            '07712345678',
        );

        $this->assertEquals(
            [
                'displayName' => $user->displayName,
                'givenName' => $user->givenName,
                'id' => $user->id,
                'jobTitle' => $user->jobTitle,
                'mail' => $user->mail,
                'officeLocation' => $user->officeLocation,
                'phone' => $user->phone,
                'surname' => $user->surname,
                'userPrincipalName' => $user->userPrincipalName,
            ],
            $user->toArray(),
        );
    }
}
