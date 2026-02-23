<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class FindTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useEntraEmulator();
    }

    public function test(): void
    {
        $this->assertEquals(
            'Gandalf Stormcrow',
            EntraUser::find('gandalf.stormcrow@networkrail.co.uk')['displayName'],
        );
    }
}
