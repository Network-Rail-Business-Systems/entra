<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Middleware\EntraTokenExists;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Middleware\EntraTokenExists;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class HandleTest extends TestCase
{
    protected EntraTokenExists $middleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = new EntraTokenExists();
    }

    public function testRedirectsWhenLoggedOut(): void
    {
        $this->assertInstanceOf(
            RedirectResponse::class,
            $this->runCheck(false, false),
        );
    }

    public function testRedirectsWhenNoToken(): void
    {
        $this->assertInstanceOf(
            RedirectResponse::class,
            $this->runCheck(true, false),
        );
    }

    public function testContinues(): void
    {
        $this->assertTrue(
            $this->runCheck(true, true),
        );
    }

    protected function runCheck(bool $auth, bool $token): RedirectResponse|true
    {
        if ($auth === true) {
            Auth::login(new User());
        }

        if ($token === true) {
            Session::put(Entra::ENTRA_TOKEN, 'hey');
        }

        return $this->middleware->handle(
            request(),
            function () {
                return true;
            },
        );
    }
}
