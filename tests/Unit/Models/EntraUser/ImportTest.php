<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Models\EntraUser;

use NetworkRailBusinessSystems\Entra\Models\EntraUser;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ImportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useEntraEmulator();
        $this->useDatabase();
    }

    public function testImportsUser(): void
    {
        $this->assertInstanceOf(
            User::class,
            EntraUser::import('Merry.Brandybuck@networkrail.co.uk'),
        );

        $this->assertDatabaseHas('users', [
            'username' => 'merry@networkrail.co.uk',
            'email' => 'merry.brandybuck@networkrail.co.uk',
        ]);
    }

    public function testHandlesMissing(): void
    {
        $this->assertNull(
            EntraUser::import('a@b.com'),
        );

        $this->assertDatabaseEmpty('users');
    }
}
