<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\MsGraph;
use NetworkRailBusinessSystems\Entra\Tests\Data\Users;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ImportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
    }

    public function testImportsUser(): void
    {
        MsGraph::partialMock()
            ->expects('get')
            ->andReturns(
                Users::make(),
            );

        $this->assertInstanceOf(
            User::class,
            EntraUser::import('a@b.com'),
        );

        $this->assertDatabaseHas('users', [
            'username' => 'JBloggs2@networkrail.co.uk',
        ]);
    }

    public function testHandlesMissing(): void
    {
        MsGraph::partialMock()
            ->expects('get')
            ->andReturnNull();

        $this->assertNull(
            EntraUser::import('a@b.com'),
        );

        $this->assertDatabaseEmpty('users');
    }
}
