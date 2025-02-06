<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class FindUsersTest extends TestCase
{
    public function test(): void
    {
        // TODO
        $this->assertEquals(
            [],
            Entra::findUsers(''),
        );
    }
}
