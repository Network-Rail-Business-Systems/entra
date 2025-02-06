<?php

namespace NetworkRailBusinessSystems\Entra\Tests;

use Dcblogdev\MsGraph\MsGraphServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use NetworkRailBusinessSystems\Entra\Tests\Data\User;
use Orchestra\Testbench\TestCase as BaseTestCase;
use NetworkRailBusinessSystems\Entra\EntraServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        config()->set('entra.user_model', User::class);
        config()->set('msgraph.dbConnection', 'testing');
    }

    protected function getPackageProviders($app): array
    {
        return [
            EntraServiceProvider::class,
            MsGraphServiceProvider::class,
        ];
    }

    protected function useDatabase(): void
    {
        $this->app->useDatabasePath(__DIR__ . '/Database');
        $this->runLaravelMigrations();
    }
}
