<?php

declare(strict_types=1);


namespace AwalHadi\LaravelToastr;

use Illuminate\Support\Facades\Blade;
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

        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Toastr', Toastr::class);
        });

        Blade::directive('h_toastr', function () {
            return <<<HTML
                <link href="{{ asset('vendor/laravel-toastr-clone/css/toastr.css') }}" rel="stylesheet">
                <script src="{{ asset('vendor/laravel-toastr-clone/js/toastr.js') }}"></script>
            HTML;
        });
    }
}
