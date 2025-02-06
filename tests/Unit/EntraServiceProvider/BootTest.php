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

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new EntraServiceProvider(app());
        $this->provider->boot();
        Route::entra();
    }

    public function test(): void
    {
        $publishes = EntraServiceProvider::$publishes[EntraServiceProvider::class];
        $key = array_key_first($publishes);

        $this->assertStringEndsWith('entra.php', $key);
        $this->assertStringEndsWith('entra.php', $publishes[$key]);

        $this->assertTrue(
            Route::hasMacro('entra'),
        );

        $this->assertTrue(
            Event::hasListeners(NewMicrosoft365SignInEvent::class)
        );

        Route::has('login');
        Route::has('logout');
    }
}
