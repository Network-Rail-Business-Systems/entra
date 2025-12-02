<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\AuthenticatesWithEntra;

use NetworkRailBusinessSystems\Entra\EntraToken;
use NetworkRailBusinessSystems\Entra\Tests\Data\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class EntraTokenTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->user = User::factory()
            ->hasEntraToken()
            ->create();
    }

    public function testLoadsExisting(): void
    {
        $this->assertHasOne($this->user, 'entraToken', EntraToken::class);
    }
}
