<?php

namespace App\Providers;

use App\Services\MercadoLibre\MlProductService;
use App\Services\MlSyncService;
use App\Services\ProductService;
use App\Services\ProductSyncService;
use Illuminate\Support\ServiceProvider;

class MLSyncProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mlSyncService', function() {

            $productService = new ProductService();

            return new MlSyncService($productService);

        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
