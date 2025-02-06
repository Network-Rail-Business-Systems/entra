<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\AuthenticatesWithEntra;

use NetworkRailBusinessSystems\Entra\Tests\Data\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class GetEntraModelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
    }

    public function testMakesNew(): void
    {
        $this->assertFalse(
            User::getEntraModel([
                'id' => 'acb123',
                'mail' => 'a@b.com',
            ])->exists,
        );
    }

    public function testLoadsExisting(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertEquals(
            $user->id,
            User::getEntraModel([
                'id' => $user->azure_id,
                'mail' => $user->email,
            ])->id,
        );
    }
}
