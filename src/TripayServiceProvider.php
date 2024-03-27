<?php

namespace Andreracodex\Tripay;

use Andreracodex\Tripay\Facades\Tripay;
use Andreracodex\Tripay\Requests\HttpClient;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class TripayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-tripay.php'),
            ], 'laravel-tripay-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-tripay');

        $this->app->singleton(ConfigManager::class, function () {
            return new ConfigManager($this->app['config']['laravel-tripay']);
        });

        $this->app->singleton(BaseApi::class, function (Application $app) {
            return new BaseApi(
                $app->make(ConfigManager::class)
            );
        });

        $this->app->singleton(HttpClient::class, function (Application $app) {
            return new HttpClient(
                $app->make(BaseApi::class)
            );
        });

        // Register the main class to use with the facade
        $this->app->bind(Tripay::class, function (Application $app) {
            return new Payment(
                $app->make(ConfigManager::class),
                $app->make(HttpClient::class)
            );
        });
    }
}
