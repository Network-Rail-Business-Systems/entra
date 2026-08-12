<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AssertsEntra;

use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraShouldReturnEmptyTest extends TestCase
{
    public function test(): void
    {
        $this->entraShouldReturnEmpty();

        $this->assertTrue(
            $this->entraShouldReturnEmpty,
        );
    }
}
