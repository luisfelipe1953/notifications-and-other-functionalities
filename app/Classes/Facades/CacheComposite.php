<?php

namespace App\Classes\Facades;

use Illuminate\Support\Facades\Facade;

class CacheComposite extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cache-composite';
    }
}
