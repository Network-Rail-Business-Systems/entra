<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Routes;

use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraLoginRouteTest extends TestCase
{
    public function test(): void
    {
        $route = Entra::entraAuthoriseRoute();
        $state = Session::get(Entra::ENTRA_STATE);

        $this->assertEquals(
            "https://login.microsoftonline.com/tenant/oauth2/v2.0/authorize?client_id=client&redirect_uri=http%3A%2F%2Fapp.url%2Fentra%2Fconnect&response_mode=query&response_type=code&scope=&state=$state",
            $route,
        );
    }
}
