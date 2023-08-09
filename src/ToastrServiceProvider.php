<?php

declare(strict_types=1);

namespace AwalHadi\LaravelToastr;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ToastrServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('toastr', function ($app) {
            return new Toastr($app['session'], $app['config']);
        });
    }

    public function boot(): void
    {
        $this->registerAlias();
        $this->publishAssetsAndConfig();
        $this->registerBladeDirective();
    }

    protected function registerAlias(): void
    {
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Toastr', Toastr::class);
        });
    }

    protected function publishAssetsAndConfig(): void
    {
        $this->publishes([
            __DIR__ . '/config/toastr.php' => config_path('toastr.php'),
            __DIR__ . '/resources/js' => public_path('vendor/laravel-toastr/js'),
            __DIR__ . '/resources/css' => public_path('vendor/laravel-toastr/css'),
        ]);
    }

    protected function registerBladeDirective(): void
    {
        // Blade::directive('h_toastr', function () {
        //     return <<<HTML
        //         <link href="{{ asset('vendor/laravel-toastr/css/toastr.css') }}" rel="stylesheet">
        //         <script src="{{ asset('vendor/laravel-toastr/js/toastr.js') }}"></script>
        //     HTML;
        // });


        Blade::directive('h_toastr', function () {
            $toastr = app('toastr');
            $scriptContent = $toastr->generateNotificationScript();

            return <<<HTML
                <link href="{{ asset('vendor/laravel-toastr/css/toastr.css') }}" rel="stylesheet">
                <script src="{{ asset('vendor/laravel-toastr/js/toastr.js') }}"></script>
                $scriptContent
            HTML;
        });
    }
}
