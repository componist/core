<?php

namespace Componist\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Component extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'component';
    }
}
