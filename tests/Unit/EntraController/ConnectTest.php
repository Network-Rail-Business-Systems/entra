<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraController;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\EntraController;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ConnectTest extends TestCase
{
    protected EntraController $controller;

    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        request()->headers->set('referer', 'https://networkrail.co.uk/a-page');

        $this->controller = new EntraController();
        $this->redirect = $this->controller->connect();
    }

    public function test(): void
    {
        $this->assertEquals(
            'https://networkrail.co.uk/a-page',
            Session::get('url.intended'),
        );

        $this->assertStringStartsWith(
            'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
            $this->redirect->getTargetUrl(),
        );
    }
}
