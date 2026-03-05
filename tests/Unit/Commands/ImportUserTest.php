<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\Commands;

use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class ImportUserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->useEntraEmulator();
    }

    public function test(): void
    {
        $this->artisan('entra:import-user')
            ->expectsQuestion(
                'What is the User\'s mail?',
                'gandalf.stormcrow@networkrail.co.uk',
            )
            ->expectsOutput('Attempting import of gandalf.stormcrow@networkrail.co.uk...')
            ->expectsOutput('Complete!');

        $this->assertDatabaseHas('users', [
            'email' => 'gandalf.stormcrow@networkrail.co.uk',
        ]);
    }
}
