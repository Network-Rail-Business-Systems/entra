<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraController;

use Illuminate\Http\RedirectResponse;
use NetworkRailBusinessSystems\Entra\EntraController;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class DisconnectTest extends TestCase
{
    protected EntraController $controller;

    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new EntraController();
        $this->redirect = $this->controller->disconnect();
    }

    public function test(): void
    {
        $this->assertStringStartsWith(
            'https://login.microsoftonline.com/common/oauth2/v2.0/logout',
            $this->redirect->getTargetUrl(),
        );
    }
}
