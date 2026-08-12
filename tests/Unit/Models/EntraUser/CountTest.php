<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class CountTest extends TestCase
{
    protected EntraAccessToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = EntraAccessToken::fake();
    }

    public function test(): void
    {
        $this->assertEquals(
            3,
            EntraUser::count(
                $this->token,
                'mail eq \'a@b.com\'',
            ),
        );
    }
}
