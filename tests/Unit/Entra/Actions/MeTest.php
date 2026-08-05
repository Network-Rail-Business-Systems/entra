<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Actions;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class MeTest extends TestCase
{
    public function test(): void
    {
        $this->assertInstanceOf(
            EntraUser::class,
            Entra::me(
                EntraAccessToken::fake(),
            ),
        );
    }
}
