<?php

namespace WdevRs\LaravelAnalytics;

use Illuminate\Support\ServiceProvider;
use WdevRs\LaravelAnalytics\Repositories\PageViewRepository;

class LaravelAnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // Load package migrations
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Load package routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-analytics.php' => config_path('laravel-analytics.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/js/components' => resource_path('js/vendor/laravel-analytics/components'),
            ], 'components');

        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-analytics.php', 'laravel-analytics');

        //Add methods to get data through Analytics facade
        $this->app->singleton('analytics', function ($app) {
            return $app->make(PageViewRepository::class);
        });
    }
}
