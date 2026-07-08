<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Traits\AuthenticatesWithEntra;

use Carbon\Carbon;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GetEntraModelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
    }

    public function testThrowsException(): void
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Your Azure Entra account details are incomplete; ensure your e-mail address has been set on your account and try again');

        User::getEntraModel([
            'id' => null,
            'email' => '',
        ]);
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

    public function testLoadsExistingFallback(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'azure_id' => null,
        ]);

        $this->assertEquals(
            $user->id,
            User::getEntraModel([
                'id' => $user->azure_id,
                'mail' => $user->email,
            ])->id,
        );
    }

    public function testLoadsSoftDeleted(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'deleted_at' => Carbon::now(),
        ]);

        $model = User::getEntraModel([
            'id' => $user->azure_id,
            'mail' => $user->email,
        ]);

        $this->assertEquals($user->id, $model->id);
    }
}
