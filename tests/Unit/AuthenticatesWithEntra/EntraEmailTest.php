<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\AuthenticatesWithEntra;

use NetworkRailBusinessSystems\Entra\Tests\Data\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraEmailTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
    }

    public function testLoadsExisting(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertEquals(
            $user->email,
            $user->entraEmail(),
        );
    }
}
