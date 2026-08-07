<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Controllers\EntraController;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Controllers\EntraController;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class LogoutTest extends TestCase
{
    protected EntraController $controller;

    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        Auth::login(new User());

        $this->controller = new EntraController();
        $this->redirect = $this->controller->logout();
    }

    public function test(): void
    {
        $this->assertFalse(
            Auth::check(),
        );

        $this->assertEquals(
            config('app.url'),
            $this->redirect->getTargetUrl(),
        );
    }
}
