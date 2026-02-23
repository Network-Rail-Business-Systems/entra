<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useEntraEmulator();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'gandalf@networkrail.co.uk',
                'gimli@networkrail.co.uk',
            ],
            array_column(
                EntraUser::list('g', select: []),
                'userPrincipalName',
            ),
        );
    }
}
