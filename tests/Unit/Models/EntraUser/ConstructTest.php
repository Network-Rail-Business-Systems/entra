<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ConstructTest extends TestCase
{
    public function testWhenBusinessPhone(): void
    {
        $user = new EntraUser(
            'abc123',
            'jbloggs@networkrail.co.uk',
            'Joe.Bloggs@networkrail.co.uk',
            'Joe Bloggs',
            'Joe',
            'Bloggs',
            'Developer',
            'Milton Keynes',
            'Business Systems',
            12345,
            ['01234567890'],
            '07712345678',
        );

        $this->assertEquals(
            'joe.bloggs@networkrail.co.uk',
            $user->mail,
        );

        $this->assertEquals(
            '01234567890',
            $user->phone,
        );
    }

    public function testWhenMobilePhone(): void
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
            'Business Systems',
            12345,
            [],
            '07712345678',
        );

        $this->assertEquals(
            '07712345678',
            $user->phone,
        );
    }
}
