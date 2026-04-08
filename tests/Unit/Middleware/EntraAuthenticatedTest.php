<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Middleware;

use Carbon\Carbon;
use Dcblogdev\MsGraph\Models\MsGraphToken;
use NetworkRailBusinessSystems\Entra\Middleware\EntraAuthenticated;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraAuthenticatedTest extends TestCase
{
    protected EntraAuthenticated $middleware;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->middleware = new EntraAuthenticated();
    }

    public function testWhenConnected(): void
    {
        MsGraphToken::create([
            'access_token' => 'abc123',
            'expires' => Carbon::tomorrow()->timestamp,
            'refresh_token' => 'def456',
            'user_id' => $this->signIn()->id,
        ]);

        $this->assertTrue(
            $this->middleware->handle(
                request(),
                function () {
                    return true;
                },
            ),
        );
    }

    public function testWhenDisconnected(): void
    {
        $redirect = $this->middleware->handle(
            request(),
            function () {
                return true;
            },
        );

        $this->assertStringStartsWith(
            'http://localhost/authorise',
            $redirect->getTargetUrl(),
        );
    }
}
