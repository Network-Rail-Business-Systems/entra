<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraToken;

use NetworkRailBusinessSystems\Entra\EntraToken;
use NetworkRailBusinessSystems\Entra\Tests\Data\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class UserTest extends TestCase
{
    protected EntraToken $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->token = EntraToken::factory()->create();
    }

    public function testLoadsExisting(): void
    {
        $this->assertBelongsTo($this->token, 'user', User::class);
    }
}
