<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraAccessToken;

use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
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
