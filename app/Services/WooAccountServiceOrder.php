<?php

namespace App\Services;

use App\Enums\ServiceCode;
use App\Enums\Status;
use App\Services\Woocommerce\WooSyncOrdersService;
use Carbon\Carbon;
use Eastwest\Json\Json;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class WooAccountServiceOrder
{

    //TODO: Manejo de errores
    public function synchronizeOrdersWoo($accountServiceId=''): string
    {
        $message = '';
        if (empty($accountServiceId))
        {
            $accountServiceWoo = DB::table('account_service')
                ->leftJoin('services','services.id','=','account_service.service_id')
                ->where('services.service_code','=',ServiceCode::WOO)
                ->where('account_service.status','=',Status::Active)
                ->whereNotNull('account_service.external_client_id')
                ->whereNotNull('account_service.external_client_secret')
                ->select(['account_service.id','account_service.account_id','account_service.service_id','account_service.last_order_sync','account_service.external_client_id','account_service.external_client_secret','account_service.external_url'])
                ->get();
        }else{
            $accountServiceWoo = DB::table('account_service')
                ->where('id','=',$accountServiceId)
                ->where('account_service.status','=',Status::Active)
                ->select(['account_service.id','account_service.account_id','account_service.service_id','account_service.last_order_sync','account_service.external_client_id','account_service.external_client_secret','account_service.external_url'])
                ->get();
        }

        $now = Carbon::now()->toIso8601ZuluString();

        $accountServiceWoo->each(function($accountService) use ($now, &$message) {
            $wooSyncOrdersService = new WooSyncOrdersService($accountService);
            $wooSyncOrdersService->getOrders();
            /**
             * * Actualizamos last_order_sync
             */
            if ($wooSyncOrdersService)
            {
                DB::table('account_service')
                    ->where('id','=',$accountService->id)
                    ->update(['last_order_sync'=>$now]);

                $message = 'ok';
            }
        });
        Log::debug($message);
        return $message;
    }
}
