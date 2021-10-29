<?php

namespace App\Services;

use App\Enums\ProductSyncStatus;
use App\Models\Product;
use App\Models\ProductSync;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductSyncService
{
    //Status
    public static function pending(Product $product )
    {
        return self::changeSyncStatus($product->id, $product->account_service_id, ProductSyncStatus::pending  );
    }
    public static function syncing(Product $product )
    {
        return self::changeSyncStatus($product->id, $product->account_service_id , ProductSyncStatus::syncing );
    }

    public static function synced(Product $product)
    {
        return self::changeSyncStatus($product->id, $product->account_service_id , ProductSyncStatus::synced );
    }

    public static function error(Product $product)
    {
        return self::changeSyncStatus($product->id, $product->account_service_id , ProductSyncStatus::error );
    }
    public static function reject(Product $product )
    {
        return self::changeSyncStatus($product->id, $product->account_service_id, ProductSyncStatus::rejected );
    }

    public static function changeSyncStatus($product_id, $account_service_id , $status )
    {

        try {

            $productSyncUpdate = ProductSync::query();
            $productSyncUpdate ->where('product_id',$product_id);
            $productSyncUpdate ->where('account_service_id',$account_service_id);
            $productSyncUpdate ->update(['status' => $status]);

            return true;
        }catch (Throwable $exception){
            Log::debug('Error');
            return false;
        }


    }
}
