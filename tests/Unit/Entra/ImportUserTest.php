<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Entra;

use NetworkRailBusinessSystems\Entra\Entra;
use NetworkRailBusinessSystems\Entra\Tests\Data\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ImportUserTest extends TestCase
{
    public function test(): void
    {
        // TODO
        $this->assertInstanceOf(
            User::class,
            Entra::importUser(''),
        );
    }
}
