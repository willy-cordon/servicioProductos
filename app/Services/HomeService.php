<?php

namespace App\Services;

use App\Enums\ProductSyncStatus;
use App\Models\AccountServiceOrder;
use App\Models\ProductSync;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class HomeService
{

    public function pendingSyncronice($userLogged)
    {
        /**
         * *Pendientes de simcronizacion
         */
        return $productSyncSyncedQuery = DB::table('account_service')
            ->leftJoin('product_syncs','product_syncs.account_service_id','=','account_service.id')
            ->where('account_id','=',$userLogged->account_id)
            ->where('product_syncs.status','=',ProductSyncStatus::pending)
            ->count();
    }

    public function productsSynced($userLogged)
    {
        /**
         * *Syncronizados
         */
        return $productSyncSyncedQuery = DB::table('account_service')
            ->leftJoin('product_syncs','product_syncs.account_service_id','=','account_service.id')
            ->where('account_id','=',$userLogged->account_id)
            ->where('product_syncs.status','=',ProductSyncStatus::synced)
            ->count();

    }

    public function ordersForAccount($userLogged,$account)
    {
        $accountServiceOrderQuery = AccountServiceOrder::query();
        $accountServiceOrderQuery->leftJoin('account_service','account_service.id','=','account_service_orders.account_service_id');
        $accountServiceOrderQuery->where('account_service.account_id','=',$userLogged->account_id);
        $accountServiceOrderQuery->select(['account_service_orders.id']);
        return $accountServiceOrder = $accountServiceOrderQuery->count();

    }

    public function countProductsSyncAdmin(): array
    {
        $countSync = [];
        $productSyncSynced = ProductSync::where('status','=',ProductSyncStatus::synced)->count();
        $productSyncPending = ProductSync::where('status','=',ProductSyncStatus::pending)->count();
        $productSyncReject = ProductSync::where('status','=',ProductSyncStatus::rejected)->count();
        $countSync['synced']=$productSyncSynced;
        $countSync['pending']=$productSyncPending;
        $countSync['reject']=$productSyncReject;

        return $countSync;




    }



}
