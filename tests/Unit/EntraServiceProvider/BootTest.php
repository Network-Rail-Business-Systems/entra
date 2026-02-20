<?php

namespace NetworkRailBusinessSystems\Entra\Tests\Unit\EntraServiceProvider;

use Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use NetworkRailBusinessSystems\Entra\EntraServiceProvider;
use NetworkRailBusinessSystems\Entra\Tests\TestCase;

class BootTest extends TestCase
{
    protected EntraServiceProvider $provider;

    protected string $basePath;

    protected string $outputPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new EntraServiceProvider(app());
        $this->provider->boot();
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
                "$this->basePath/migrations" => "$this->outputPath/database/migrations",
            ],
            $publishes,
        );

        $this->assertTrue(
            Route::hasMacro('entra'),
        );

        $this->assertTrue(
            Event::hasListeners(NewMicrosoft365SignInEvent::class),
        );

        Route::has('login');
        Route::has('logout');
    }
}
