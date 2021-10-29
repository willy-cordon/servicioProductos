<?php

namespace App\Providers;

use App\Services\MercadoLibre\MLAccountServiceSyncOrders;
use App\Services\MLAccountServiceOrder;
use Illuminate\Support\ServiceProvider;

class MLAccountServiceOrderSyncProvider extends ServiceProvider
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
        $this->app->bind('MLAccountServiceOrderSync', function() {
            $MLaccountServiceSync = new MLAccountServiceSyncOrders();
            return new MLAccountServiceOrder($MLaccountServiceSync);
        });
    }
}
