<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Facades\MsGraph;

use Dcblogdev\MsGraph\Facades\MsGraph as BaseMsGraph;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Facades\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
class ConnectTest extends TestCase
{
    protected RedirectResponse $redirect;

    public function testRedirectsToAzure(): void
    {
        $this->mock('overload:' . BaseMsGraph::class, function ($mock) {
            $redirect = redirect('http://localhost/authorise');
            $mock->expects('connect')->andReturns($redirect);
        });

        request()->server->set('REQUEST_URI', 'http://localhost/entra/connect');
        request()->headers->set('referer', 'http://localhost/previous');

        $this->redirect = MsGraph::connect();

        $this->assertStringStartsWith(
            'http://localhost/authorise',
            $this->redirect->getTargetUrl(),
        );

        $this->assertEquals(
            'http://localhost/previous',
            Session::get('url.intended'),
        );
    }

    public function testRedirectsToIntendedPrevious(): void
    {
        $this->mock('overload:' . BaseMsGraph::class, function ($mock) {
            $redirect = redirect(config('msgraph.msgraphLandingUri'));
            $mock->expects('connect')->andReturns($redirect);
        });

        request()->server->set('REQUEST_URI', 'http://localhost/entra/connect');
        request()->headers->set('referer', 'http://localhost/previous');
        request()->query->set('code', 'abc123');

        Session::put('url.intended', 'http://localhost/previous');

        $this->redirect = MsGraph::connect();

        $this->assertEquals(
            'http://localhost/previous',
            $this->redirect->getTargetUrl(),
        );
    }

    public function testRedirectsToIntendedCurrent(): void
    {
        $this->mock('overload:' . BaseMsGraph::class, function ($mock) {
            $redirect = redirect(config('msgraph.msgraphLandingUri'));
            $mock->expects('connect')->andReturns($redirect);
        });

        request()->server->set('REQUEST_URI', 'http://localhost/current');

        $this->redirect = MsGraph::connect();

        $this->assertEquals(
            'http://localhost/current',
            $this->redirect->getTargetUrl(),
        );
    }
}
