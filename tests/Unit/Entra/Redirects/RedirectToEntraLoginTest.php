<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Redirects;

use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RedirectToEntraLoginTest extends TestCase
{
    public function test(): void
    {
        $redirect = Entra::redirectToEntraAuthenticate();

        $this->assertTrue(
            Session::has(Entra::ENTRA_INTENDED),
        );

        $this->assertStringStartsWith(
            'https://login.microsoftonline.com/tenant/oauth2/v2.0/authorize',
            $redirect->getTargetUrl(),
        );
    }
}
