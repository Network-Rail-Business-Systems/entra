<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Controllers\EntraController;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Controllers\EntraController;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\FormRequests\EntraCodeRequest;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ConnectTest extends TestCase
{
    protected EntraController $controller;

    protected RedirectResponse $redirect;

    protected EntraCodeRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new EntraCodeRequest([
            'code' => 'abc123',
            'state' => 'gabba',
            'session_state' => 'hey',
        ]);

        $this->controller = new EntraController();
        $this->redirect = $this->controller->connect($this->request);
    }

    public function test(): void
    {
        $this->assertTrue(
            Auth::check(),
        );

        $this->assertTrue(
            Session::has(Entra::ENTRA_TOKEN),
        );

        $this->assertEquals(
            Entra::intendedRoute(),
            $this->redirect->getTargetUrl(),
        );
    }
}
