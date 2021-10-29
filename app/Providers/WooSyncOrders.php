<?php

namespace App\Providers;

use App\Services\WooAccountServiceOrder;
use Illuminate\Support\ServiceProvider;

class WooSyncOrders extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('wooSyncOrders', function() {
            return new WooAccountServiceOrder();
        });
    }
}
