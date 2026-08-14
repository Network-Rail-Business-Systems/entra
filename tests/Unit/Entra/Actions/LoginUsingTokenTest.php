<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Actions;

use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class LoginUsingTokenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Entra::loginUsingToken(
            EntraAccessToken::fake(),
        );
    }

    public function test(): void
    {
        $this->assertTrue(
            Auth::check(),
        );
    }
}
