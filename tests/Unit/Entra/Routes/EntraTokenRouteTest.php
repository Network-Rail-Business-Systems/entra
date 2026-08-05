<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Routes;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraTokenRouteTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            'https://login.microsoftonline.com/tenant/oauth2/v2.0/token',
            Entra::entraTokenRoute(),
        );
    }
}
