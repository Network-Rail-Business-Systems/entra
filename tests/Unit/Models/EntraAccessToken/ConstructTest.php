<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraAccessToken;

use Carbon\Carbon;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ConstructTest extends TestCase
{
    protected Carbon $now;

    protected EntraAccessToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->now = Carbon::today();
        Carbon::setTestNow($this->now);

        $this->token = new EntraAccessToken(
            'abc123',
            20,
            'def456',
            'scopes',
            'Bearer',
            50,
        );
    }

    public function test(): void
    {
        $this->assertEquals(
            $this->now->clone()->addSeconds(20),
            $this->token->expires_at,
        );
    }
}
