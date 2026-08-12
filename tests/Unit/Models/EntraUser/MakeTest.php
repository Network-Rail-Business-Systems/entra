<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class MakeTest extends TestCase
{
    public function test(): void
    {
        $user = EntraUser::make([
            'businessPhones' => [
                '01234567890',
            ],
            'department' => 'Chilled Goods',
            'displayName' => 'Joe Bloggs',
            'employeeId' => '123456',
            'givenName' => 'Joe',
            'id' => 'abc123',
            'jobTitle' => 'Developer',
            'mail' => 'joe.bloggs@networkrail.co.uk',
            'officeLocation' => 'Milton Keynes',
            'mobilePhone' => '07712345678',
            'surname' => 'Bloggs',
            'userPrincipalName' => 'jbloggs@networkrail.co.uk',
            '@odata.context' => 'gabba',
            'preferredLanguage' => 'gabba',
        ]);

        $this->assertEquals(
            'abc123',
            $user->id,
        );
    }
}
