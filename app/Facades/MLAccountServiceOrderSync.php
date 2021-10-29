<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static void getServiceML()
 * @see \App\Services\MLAccountServiceOrder
 */
class MLAccountServiceOrderSync extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MLAccountServiceOrderSync';
    }
}
