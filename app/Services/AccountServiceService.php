<?php

namespace App\Services;

use App\Enums\AccountServiceStatus;
use App\Models\Account;
use Eastwest\Json\Json;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class AccountServiceService
{

    /**
     * @param $accountId
     * @param $serviceId
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getIfActive($accountId, $serviceId)
    {

        return DB::table('account_service')
            ->where('service_id',$serviceId)
            ->where('account_id',$accountId)
            ->where('status','=',AccountServiceStatus::Active)
            ->first();


    }


    /**
     * @param $accountId
     * @return \Illuminate\Support\Collection
     */
    public function getAllActiveForAccount($accountId)
    {
        return DB::table('account_service')
            ->where('account_id',$accountId)
            ->where('status','=',AccountServiceStatus::Active)
            ->get();
    }


}
