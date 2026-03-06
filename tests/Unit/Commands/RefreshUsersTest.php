<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Commands;

use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class RefreshUsersTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->useEntraEmulator();

        User::factory()
            ->count(3)
            ->sequence(
                ['email' => 'gandalf.stormcrow@networkrail.co.uk'],
                ['email' => 'frodo.baggins@networkrail.co.uk'],
                ['email' => 'aragorn.elessar@networkrail.co.uk'],
            )
            ->create();
    }

    public function test(): void
    {
        $this->artisan('entra:refresh-users')
            ->expectsOutput('This command will attempt to refresh every User in the database from Entra')
            ->expectsOutput("There are 3 Users to process; this may take some time.")
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsOutput('Starting process...')
            ->expectsOutput('1/3 | Processing gandalf.stormcrow@networkrail.co.uk...')
            ->expectsOutput('2/3 | Processing frodo.baggins@networkrail.co.uk...')
            ->expectsOutput('3/3 | Processing aragorn.elessar@networkrail.co.uk...')
            ->expectsOutput('Complete!');
    }
}
