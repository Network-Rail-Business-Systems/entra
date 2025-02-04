<?php

namespace NetworkRailBusinessSystems\Entra\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase as BaseTestCase;
use NetworkRailBusinessSystems\Entra\EntraServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;

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
}
