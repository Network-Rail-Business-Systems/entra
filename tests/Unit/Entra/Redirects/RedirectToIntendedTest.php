<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Redirects;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RedirectToIntendedTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            Entra::intendedRoute(),
            Entra::redirectToIntended()->getTargetUrl(),
        );
    }
}
