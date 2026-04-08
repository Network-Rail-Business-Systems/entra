<?php

namespace NetworkRailBusinessSystems\Entra;

use Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use NetworkRailBusinessSystems\Entra\Commands\ImportUser;
use NetworkRailBusinessSystems\Entra\Commands\RefreshUsers;
use NetworkRailBusinessSystems\Entra\Middleware\EntraAuthenticated;

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

        $this->commands([
            ImportUser::class,
            RefreshUsers::class,
        ]);

        Route::aliasMiddleware('EntraAuthenticated', EntraAuthenticated::class);

        Route::macro('entra', function () {
            Route::prefix('/entra')
                ->controller(EntraController::class)
                ->group(function () {
                    Route::get('/connect', 'connect')->name('login');

                    Route::middleware('EntraAuthenticated')->group(function () {
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
