<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra\Actions;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Exceptions\EntraException;
use NetworkRailBusinessSystems\Entra\Models\EntraAccessToken;
use NetworkRailBusinessSystems\Entra\Models\EntraUser;
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

    public function testThrows(): void
    {
        $this->expectException(EntraException::class);

        $this->entraShouldFail();

        Entra::me(
            EntraAccessToken::fake(),
        );
    }
}
