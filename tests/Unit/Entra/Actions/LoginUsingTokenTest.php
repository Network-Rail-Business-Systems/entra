<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Actions;

use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
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

    public function testAuthenticatedUserUsingEmulatorId(): void
    {
        $emulatorId = 'grp123ab-6789-01de-f2g3-45678hijk9lm';

        config([
            'entra.emulator.enabled' => true,
            'entra.emulator.id' => $emulatorId,
        ]);

        Entra::loginUsingToken(EntraAccessToken::fake());

        $this->assertAuthenticated();

        $this->assertSame(
            $emulatorId,
            User::$userAzureId,
        );
    }
}
