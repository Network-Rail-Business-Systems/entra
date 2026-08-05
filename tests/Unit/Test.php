<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class Test extends TestCase
{
    public function test(): void
    {
        dd(
            Entra::getGenericAccessToken(),
        );
    }
}

https://login.microsoftonline.com/c22cc3e1-5d7f-4f4d-be03-d5a158cc9409/login
