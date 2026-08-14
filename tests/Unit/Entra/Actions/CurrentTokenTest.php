<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Actions;

use Illuminate\Support\Facades\Session;
use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class CurrentTokenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Session::put(
            Entra::ENTRA_TOKEN,
            EntraAccessToken::fake(),
        );
    }

    public function test(): void
    {
        $this->assertInstanceOf(
            EntraAccessToken::class,
            Entra::currentToken(),
        );
    }
}
