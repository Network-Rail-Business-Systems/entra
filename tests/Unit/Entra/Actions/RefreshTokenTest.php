<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Actions;

use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;
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
}
