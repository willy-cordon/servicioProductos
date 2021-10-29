<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static void syncroniceProducts()
 * @see \App\Services\MlSyncService
 */
class MLSyncService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mlSyncService';
    }
}
