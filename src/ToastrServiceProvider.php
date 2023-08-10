<?php

declare(strict_types=1);

namespace AwalHadi\LaravelToastr;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use AwalHadi\LaravelToastr\ToastrFacade;

class ToastrServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('toastr', function ($app) {
            return new \AwalHadi\LaravelToastr\Toastr($app['session'], $app['config']);
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
            $loader->alias('Toastr', ToastrFacade::class); // Make sure this points to the facade class
        });
    }

    protected function publishAssetsAndConfig(): void
    {
        $this->publishes([
            __DIR__ . '/resources/js/toastr.js' => public_path('vendor/laravel-toastr/js/toastr.js'),
            __DIR__ . '/resources/css/toastr.css' => public_path('vendor/laravel-toastr/css/toastr.css'),
            __DIR__ . '/config/toastr.php' => config_path('toastr.php'),
        ]);
    }

    protected function registerBladeDirective(): void
    {
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
