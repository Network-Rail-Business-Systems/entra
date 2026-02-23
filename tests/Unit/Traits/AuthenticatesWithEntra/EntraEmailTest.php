<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AuthenticatesWithEntra;

use NetworkRailBusinessSystems\Entra\Tests\Models\User;
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
        /** @var \NetworkRailBusinessSystems\Entra\Tests\Models\User $user */
        $user = User::factory()->create();

        $this->assertEquals(
            $user->email,
            $user->entraEmail(),
        );
    }
}
