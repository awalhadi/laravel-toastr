<?php

declare(strict_types=1);

namespace AwalHadi\LaravelToastr\Facades;

use Illuminate\Support\Facades\Facade;

class Toastr extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'toastr';
    }
}
