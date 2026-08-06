<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraAccessToken;

use Carbon\Carbon;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class HasExpiredTest extends TestCase
{
    protected EntraAccessToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = EntraAccessToken::fake();
    }

    public function testTrueWhen(): void
    {
        $this->token->expires_at = Carbon::yesterday();

        $this->assertTrue(
            $this->token->hasExpired(),
        );
    }

    public function testFalseWhen(): void
    {
        $this->token->expires_at = Carbon::tomorrow();

        $this->assertFalse(
            $this->token->hasExpired(),
        );
    }
}
