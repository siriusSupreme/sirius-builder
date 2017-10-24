<?php

namespace Sirius\Builder\Facades;

use Illuminate\Support\Facades\Facade;

class Admin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Sirius\Builder\Admin::class;
    }
}
