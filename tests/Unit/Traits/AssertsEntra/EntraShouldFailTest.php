<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AssertsEntra;

use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraShouldFailTest extends TestCase
{
    public function test(): void
    {
        $this->entraShouldFail('Gabba', 'Hey');

        $this->assertTrue(
            $this->entraShouldFail,
        );

        $this->assertEquals(
            'Gabba',
            $this->entraError,
        );

        $this->assertEquals(
            'Hey',
            $this->entraErrorDescription,
        );
    }
}
