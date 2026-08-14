<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Controllers\EntraController;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Entra\Controllers\EntraController;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class LoginTest extends TestCase
{
    protected EntraController $controller;

    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new EntraController();
    }

    public function testRedirectsIntended(): void
    {
        Auth::login(new User());

        $this->redirect = $this->controller->login();

        $this->assertEquals(
            Entra::intendedRoute(),
            $this->redirect->getTargetUrl(),
        );
    }

    public function testRedirectsLogin(): void
    {
        $this->redirect = $this->controller->login();

        $this->assertStringStartsWith(
            substr(Entra::entraLoginRoute(), 0, -16),
            $this->redirect->getTargetUrl(),
        );
    }
}
