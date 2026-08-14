<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraAccessToken;

use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RefreshTest extends TestCase
{
    protected EntraAccessToken $oldToken;

    protected EntraAccessToken $newToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->oldToken = EntraAccessToken::fake();
        $this->newToken = $this->oldToken->refresh();
    }

    public function testTrueWhen(): void
    {
        $this->assertNotEquals(
            $this->oldToken->expires_at,
            $this->newToken->expires_at,
        );
    }
}
