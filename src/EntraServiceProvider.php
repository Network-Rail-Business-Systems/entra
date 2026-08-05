<?php

namespace NetworkRailBusinessSystems\Entra;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EntraServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config.php',
            'entra',
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('entra.php'),
        ], 'entra');

        Route::aliasMiddleware('EntraAuthenticated', EntraAuthenticated::class);

        Route::macro('entra', function () {
            Route::prefix('/entra')
                ->name('entra.')
                ->controller(EntraController::class)
                ->group(function () {
                    Route::get('/login', 'login')->name('login');
                    Route::get('/connect', 'connect')->name('connect');
                });
        });
    }
}
