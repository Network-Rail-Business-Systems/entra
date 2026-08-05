<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Routes;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RedirectUrlRouteTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            'http://app.url/entra/connect',
            Entra::redirectUrlRoute(),
        );
    }
}
