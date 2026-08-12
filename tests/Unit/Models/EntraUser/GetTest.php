<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class GetTest extends TestCase
{
    protected EntraAccessToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = EntraAccessToken::fake();
    }

    public function testFull(): void
    {
        $this->assertInstanceOf(
            EntraUser::class,
            EntraUser::get(
                $this->token,
                'mail',
                'a@b.com',
            ),
        );
    }

    public function testEmpty(): void
    {
        $this->entraShouldReturnEmpty();

        $this->assertNull(
            EntraUser::get(
                $this->token,
                'mail',
                'a@b.com',
            ),
        );
    }
}
