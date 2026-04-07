<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraController;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\EntraController;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class IntendedTest extends TestCase
{
    protected EntraController $controller;

    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        Session::put('url.intended', 'https://networkrail.co.uk/a-page');

        $this->controller = new EntraController();
        $this->redirect = $this->controller->intended();
    }

    public function test(): void
    {
        $this->assertEquals(
            'https://networkrail.co.uk/a-page',
            $this->redirect->getTargetUrl(),
        );
    }
}
