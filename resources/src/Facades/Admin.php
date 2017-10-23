<?php

namespace Sirius\Builder\Facades;

use Sirius\Support\Facades\Facade;

class Admin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Sirius\Builder\Admin::class;
    }
}
