<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static void synchronizeOrdersWoo()
 * @see \App\Services\WooAccountServiceOrder
 */
class WooSyncOrders extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wooSyncOrders';
    }
}
