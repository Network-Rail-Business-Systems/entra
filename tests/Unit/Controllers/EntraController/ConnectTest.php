<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Controllers\EntraController;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Controllers\EntraController;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\FormRequests\EntraCodeRequest;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
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
    }

    public function testWhenCode(): void
    {
        $this->redirect = $this->controller->connect($this->request);

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

    public function testWhenToken(): void
    {
        $token = EntraAccessToken::fake();
        $token->expires_at = Carbon::yesterday();
        Session::put(Entra::ENTRA_TOKEN, $token);

        $this->redirect = $this->controller->connect($this->request);

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
