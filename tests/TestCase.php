<?php

namespace NetworkRailBusinessSystems\Entra\Tests;

use AnthonyEdmonds\LaravelTestingTraits\AssertsRelationships;
use AnthonyEdmonds\LaravelTestingTraits\AssertsValidationRules;
use AnthonyEdmonds\LaravelTestingTraits\SignsInUsers;
use Illuminate\Foundation\Testing\WithFaker;
use NetworkRailBusinessSystems\Entra\EntraServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    use AssertsRelationships;
    use AssertsValidationRules;
    use SignsInUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    protected function getPackageProviders($app): array
    {
        return [
            EntraServiceProvider::class,
        ];
    }

    protected function useDatabase(): void
    {
        $this->app->useDatabasePath(__DIR__ . '/Database');
        $this->runLaravelMigrations();
    }
}
