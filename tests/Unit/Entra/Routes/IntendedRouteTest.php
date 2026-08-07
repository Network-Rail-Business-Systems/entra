<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Routes;

use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class IntendedRouteTest extends TestCase
{
    public function testWhenSessionSet(): void
    {
        Session::put(
            Entra::ENTRA_INTENDED,
            'time-to-go',
        );

        $this->assertEquals(
            'time-to-go',
            Entra::intendedRoute(),
        );
    }

    public function testWhenNot(): void
    {
        $this->assertEquals(
            'http://localhost',
            Entra::intendedRoute(),
        );
    }
}
