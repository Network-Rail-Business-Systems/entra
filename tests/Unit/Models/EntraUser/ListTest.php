<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Models\EntraList;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ListTest extends TestCase
{
    protected EntraAccessToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = EntraAccessToken::fake();
    }

    public function test(): void
    {
        $this->assertInstanceOf(
            EntraList::class,
            EntraUser::list(
                $this->token,
                'mail eq \'a@b.com\'',
                ['mail'],
                50,
                ['Content-Type' => 'text/json'],
            ),
        );
    }
}
