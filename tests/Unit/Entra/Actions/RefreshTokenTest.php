<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Actions;

use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Exceptions\EntraException;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RefreshTokenTest extends TestCase
{
    public function test(): void
    {
        $this->assertInstanceOf(
            EntraAccessToken::class,
            Entra::refreshToken(
                EntraAccessToken::fake(),
            ),
        );

        $this->assertInstanceOf(
            EntraAccessToken::class,
            Session::get(Entra::ENTRA_TOKEN),
        );
    }

    public function testThrows(): void
    {
        $this->expectException(EntraException::class);

        $this->entraShouldFail();

        Entra::refreshToken(
            EntraAccessToken::fake(),
        );
    }
}
