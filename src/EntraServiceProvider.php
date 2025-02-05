<?php

namespace NetworkRailBusinessSystems\Entra;

use Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EntraServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/entra.php',
            'entra',
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/entra.php' => config_path('entra.php'),
        ], 'entra');

        Route::macro('entra', function () {
            Route::prefix('/entra')
                ->controller(EntraController::class)
                ->group(function () {
                    Route::middleware('guest')->group(function () {
                        Route::get('/connect', 'connect')->name('login');
                    });

                    Route::middleware('MsGraphAuthenticated')->group(function () {
                        Route::get('/disconnect', 'disconnect')->name('logout');
                    });
                });
        });

        Event::listen(
            NewMicrosoft365SignInEvent::class,
            [EntraListener::class, 'handle'],
        );
    }
}
