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
            __DIR__ . '/../../config/govuk.php' => config_path('govuk.php'),
        ], 'entra');

        Route::macro('entra', function () {
            Route::prefix('/entra')
                ->name('entra.')
                ->controller(EntraController::class)
                ->group(function () {
                    Route::middleware('guest')->group(function () {
                        Route::get('/connect', 'connect')->name('connect');
                    });

                    Route::middleware('MsGraphAuthenticated')->group(function () {
                        Route::get('/disconnect', 'disconnect')->name('disconnect');
                    });
                });
        });

        // TODO Is this needed? I think so
        Event::listen(
            NewMicrosoft365SignInEvent::class,
            [EntraListener::class, 'handle'],
        );

        // TODO Currently done in bootstrap/app
        app('middleware')->redirectGuestsTo(function () {
            return route('entra.connect');
        });
    }
}
