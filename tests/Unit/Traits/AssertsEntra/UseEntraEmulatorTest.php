<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AssertsEntra;

use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class UseEntraEmulatorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useEntraEmulator();
    }

    public function testLoadsExisting(): void
    {
        $this->assertTrue(
            config('entra.emulator.enabled'),
        );
    }
}
