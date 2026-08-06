<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraServiceProvider;

use Illuminate\Support\Facades\Route;
use NetworkRailBusinessSystems\Entra\EntraServiceProvider;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class BootTest extends TestCase
{
    protected string $basePath;

    protected string $outputPath;

    protected function setUp(): void
    {
        parent::setUp();

        Route::entra();

        $this->basePath = realpath(__DIR__ . '/../../../src');
        $this->outputPath = base_path();
    }

    public function test(): void
    {
        $publishes = EntraServiceProvider::$publishes[EntraServiceProvider::class];

        $this->assertEquals(
            [
                "$this->basePath/config.php" => "$this->outputPath/config/entra.php",
            ],
            $publishes,
        );

        Route::hasMiddlewareGroup('EntraAuthenticated');
        Route::hasMiddlewareGroup('EntraTokenExists');

        $this->assertTrue(
            Route::hasMacro('entra'),
        );

        Route::has('login');
        Route::has('connect');
        Route::has('logout');
    }
}
