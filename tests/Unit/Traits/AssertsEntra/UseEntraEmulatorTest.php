<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AssertsEntra;

use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class UseEntraEmulatorTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            'client',
            config('entra.client'),
        );
    }
}
