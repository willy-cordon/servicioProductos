<?php

namespace App\Services\MercadoLibre;

use App\Enums\Status;
use App\Http\Clients\MlClient;
use App\Models\AccountServiceOrder;
use Carbon\Carbon;
use Eastwest\Json\Json;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

final class MLAccountServiceSyncOrders
{

//    /**
//     * MLAccountServiceSyncOrders constructor.
//     * @throws \GuzzleHttp\Exception\GuzzleException
//     */
//    private $mlClient;
//    public function __construct($account_service)
//    {
//        $this->mlClient = new MlClient($account_service->id);
//    }

    public function syncOrders($accountService,$to)
    {
        $mlClient = new MlClient($accountService->id);
        if (empty($last_order_sync))
        {
            $url =Str::replaceArray('{id}', [$accountService->user_id],config('api.ml_url_orders.url_order'));
        }else{
            $urlId =Str::replaceArray('{id}', [$accountService->user_id],config('api.ml_url_orders.url_orders_from_to'));
            $urlFrom =Str::replaceArray('{from}', [$last_order_sync],$urlId);
            $url =Str::replaceArray('{to}', [$to],$urlFrom);
        }

        $results[$accountService->id] = $mlClient->getAsync(
            $url
        )->then(
            function (ResponseInterface $response) use ($accountService) {

                Log::debug($response->getStatusCode());
                Log::debug($response->getBody());
                $responseData = Json::decode($response->getBody());

//                $createSuccess = false;
                if($response->getStatusCode() == 200){

                    foreach ($responseData->results as  $value)
                    {
                        /**
                         * ?Primer nivel seller->nickname & seller->id (data = payments)
                         * ?Segundo nivel payments
                         */
                        foreach ($value->payments as $payment)
                        {

                            $createAccountServiceOrder = AccountServiceOrder::updateOrCreate(
                                [
                                    'external_order_id' => $payment->order_id,
                                    'external_seller_id' => $value->seller->id
                                ],
                                [
                                    'external_order_id'=>$payment->order_id,
                                    'external_seller_id' => $value->seller->id,
                                    'status'=> Status::Active
                                ]
                            );

                            $createAccountServiceOrder->external_data = [$value];
                            $createAccountServiceOrder->account_service_id = $accountService->id;
                            $createAccountServiceOrder->save();
                        }

                    }


//                    if ($createProductSync->wasRecentlyCreated){
//                        $createProductSync->action = ProductSyncAction::create;
//                    }else{
//                        $createProductSync->action = ProductSyncAction::update;
//                    }

                }
            },
            function (RequestException $e){
                Log::error($e->getMessage());
            }
        );
        $responses = Utils::settle($results)->wait();
        Log::debug($responses);
        return $responses;

    }
}
