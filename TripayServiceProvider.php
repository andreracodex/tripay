<?php

namespace Andreracodex\Tripay;

use Illuminate\Support\ServiceProvider;

class TripayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->make('Andreracodex\Tripay\TripayController');
        $this->loadViewsFrom(__DIR__.'/views/tripay', 'tripay');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // include __DIR__.'/routes/routes.php';

        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->publishes([
            __DIR__.'/config/tripays.php' => config_path('tripays.php'),
            __DIR__.'/views/tripay' => resource_path('views/tripay'),
        ]);
    }
}
