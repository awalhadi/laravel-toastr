<?php

namespace AwalHadi\LaravelToastr;

use Illuminate\Support\Facades\Facade;

class ToastrFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'toastr'; // This should match the key used to bind the class in the service provider
    }
}
