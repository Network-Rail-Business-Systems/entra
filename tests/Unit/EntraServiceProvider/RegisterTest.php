<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraServiceProvider;

use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test(): void
    {
        $this->assertTrue(
            config()->has('entra'),
        );
    }
}
