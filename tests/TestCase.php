<?php

namespace NetworkRailBusinessSystems\Entra\Tests;

use AnthonyEdmonds\LaravelTestingTraits\AssertsRelationships;
use AnthonyEdmonds\LaravelTestingTraits\AssertsValidationRules;
use AnthonyEdmonds\LaravelTestingTraits\SignsInUsers;
use Dcblogdev\MsGraph\MsGraphServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use NetworkRailBusinessSystems\Entra\EntraServiceProvider;
use NetworkRailBusinessSystems\Entra\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Traits\AssertsEntra;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use AssertsEntra;
    use WithFaker;
    use AssertsRelationships;
    use AssertsValidationRules;
    use SignsInUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        config()->set('testing-traits.user_model', User::class);
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
