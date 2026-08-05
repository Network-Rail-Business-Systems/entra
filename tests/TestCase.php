<?php

namespace NetworkRailBusinessSystems\Entra\Tests;

use AnthonyEdmonds\LaravelTestingTraits\AssertsValidationRules;
use NetworkRailBusinessSystems\Entra\AssertsEntra;
use NetworkRailBusinessSystems\Entra\EntraServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use AssertsEntra;
    use AssertsValidationRules;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.url', 'http://app.url');

        $this->useEntraEmulator();
        $this->withoutVite();
    }

    protected function getPackageProviders($app): array
    {
        return [
            EntraServiceProvider::class,
        ];
    }
}
