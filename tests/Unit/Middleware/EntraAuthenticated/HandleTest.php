<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Middleware\EntraAuthenticated;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Middleware\EntraAuthenticated;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class HandleTest extends TestCase
{
    protected EntraAuthenticated $middleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->middleware = new EntraAuthenticated();
    }

    public function testRedirectsWhenLoggedOut(): void
    {
        $this->assertInstanceOf(
            RedirectResponse::class,
            $this->runCheck(false),
        );
    }

    public function testContinues(): void
    {
        $this->assertTrue(
            $this->runCheck(true),
        );
    }

    protected function runCheck(bool $auth): RedirectResponse|true
    {
        if ($auth === true) {
            Auth::login(new User());
        }

        return $this->middleware->handle(
            request(),
            function () {
                return true;
            },
        );
    }
}
