<?php

namespace App\Services;

use App\Enums\ServiceCode;
use App\Enums\Status;
use App\Models\Service;
use App\Services\MercadoLibre\MLAccountServiceSyncOrders;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class MLAccountServiceOrder
{

    /**
     * MLAccountServiceOrder constructor.
     */
    private $MLAccountServiceSyncOrders;
    public function __construct(MLAccountServiceSyncOrders $MLAccountServiceSyncOrders)
    {
        $this->MLAccountServiceSyncOrders = $MLAccountServiceSyncOrders;
    }

    public function getServiceML($accountServiceId='')
    {

            $servicesQuery = Service::query();
            $servicesQuery-> leftJoin('account_service','account_service.service_id','=','services.id');
            $servicesQuery->where('account_service.status',Status::Active);
            $servicesQuery->where('services.service_code',ServiceCode::ML);
            if (!empty($accountServiceId)){
                $servicesQuery->where('account_service.id',$accountServiceId);
            }
            $servicesQuery->whereNotNull('account_service.user_id');
            $servicesQuery->select(['account_service.id','account_service.user_id','account_service.last_order_sync']);
            $services = $servicesQuery->get();


        $to = Carbon::now()->shiftTimezone('America/Buenos_Aires')->toAtomString();
        $messageMl='';
        $services->each(function($account_service) use ($to, &$messageMl) {

            try {

                $getOrders = $this->MLAccountServiceSyncOrders->syncOrders($account_service,$to);
                if ($getOrders)
                {
                    DB::table('account_service')
                        ->where('id','=',$account_service->id)
                        ->update(['last_order_sync'=>Carbon::now()->shiftTimezone('America/Buenos_Aires')->toAtomString()]);
                    $messageMl = 'ok';
                }

            } catch (\Exception | GuzzleException $e) {
                Log::debug($e);
                $messageMl ='error';
            }
        });

        return $messageMl;

    }
}
