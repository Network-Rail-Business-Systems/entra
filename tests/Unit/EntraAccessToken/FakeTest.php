<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraAccessToken;

use NetworkRailBusinessSystems\Entra\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class FakeTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            'abc123',
            EntraAccessToken::fake()->accessToken,
        );
    }
}
