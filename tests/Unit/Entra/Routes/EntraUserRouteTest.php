<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Routes;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraUserRouteTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            'https://graph.microsoft.com/v1.0/users',
            Entra::entraUserRoute(),
        );
    }
}
