<?php

namespace Awalhadi\LaravelToastr;

use Illuminate\Support\ServiceProvider;

class ToastrServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/toastr.php', 'toastr');

        $this->app->singleton('toastr', function ($app) {
            return new Toastr($app['session'], $app['config']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/toastr.php' => config_path('toastr.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'toastr');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/toastr'),
        ], 'views');

        // Load helper functions
        require_once __DIR__ . '/toastr_helpers.php';
    }
}