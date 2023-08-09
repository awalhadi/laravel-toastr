<?php


namespace AwalHadi\LaravelToastr;

use Illuminate\Support\ServiceProvider;

class ToastrServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('toastr', function ($app) {
            return new Toastr($app['session'], $app['config']);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/toastr.php' => config_path('toastr.php'),
        ], 'config');
    }
}
