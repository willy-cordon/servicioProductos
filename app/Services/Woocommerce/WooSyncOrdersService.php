<?php

namespace App\Services\Woocommerce;

use App\Enums\Status;
use App\Models\AccountServiceOrder;
use Carbon\Carbon;
use Eastwest\Json\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;

final class WooSyncOrdersService
{

    /**
     * WooSyncOrdersService constructor.
     */
    private $accountServiceId;
    private $externalClientId;
    private $externalClientSecret;
    private $externalUrl;
    private $lastOrderSync;
    public function __construct($accountService)
    {
        $this->accountServiceId = $accountService->id;
        $this->externalClientId = $accountService->external_client_id;
        $this->externalClientSecret = $accountService->external_client_secret;
        $this->externalUrl = $accountService->external_url;
        $this->lastOrderSync = $accountService->last_order_sync;
    }
    //TODO: Manejo de errores
    public function getOrders()
    {
        Log::debug('Syncronize orders woo');

        $client = new Client();
        $now = Carbon::now()->toIso8601ZuluString();

        if (empty($this->lastOrderSync))
        {
            $urlExternal =Str::replaceArray('{external_url}', [$this->externalUrl],config('api.woo_url_orders.url'));
            $urlClientID =Str::replaceArray('{consumer_key}', [$this->externalClientId],$urlExternal);
            $url = Str::replaceArray('{consumer_secret}', [$this->externalClientSecret],$urlClientID);

        }else{
            $urlExternal =Str::replaceArray('{external_url}', [$this->externalUrl],config('api.woo_url_orders.url_from_to'));
            $urlClientID =Str::replaceArray('{consumer_key}', [$this->externalClientId],$urlExternal);
            $urlSecret = Str::replaceArray('{consumer_secret}', [$this->externalClientSecret],$urlClientID);
            $urlAfter = Str::replaceArray('{after}', [$this->lastOrderSync],$urlSecret);
            $url = Str::replaceArray('{before}', [$now],$urlAfter);
        }

        $responseCount = $client->get($url);
        $pepe = $responseCount->getHeaders();
        $totalPage = $pepe['x-wp-totalpages'][0];
        $page=0;
        $data=[];
        for ($i=0; $i<$totalPage;$i++ )
        {
            $page++;
            $data[] = $this->saveResponse($client,$url,$page);
        }
        return $data;
    }


    public function saveResponse($client,$url,$page)
    {

        $results = $client->getAsync(
           $url.'&page='.$page
        )->then(
            function (ResponseInterface $response) {
                Log::debug($response->getStatusCode());
//                Log::debug($response->getBody());
                if ($response->getStatusCode() == 200)
                {
                    $responseData = Json::decode($response->getBody());

                    foreach ($responseData as $value)
                    {
                        $createAccountServiceOrder = AccountServiceOrder::updateOrCreate(
                            [
                                'external_order_id' => $value->id,
                                'external_status' => $value->status
                            ],
                            [
                                'external_order_id' => $value->id,
                                'status'=> Status::Active,
                                'external_status'=>$value->status,
                                'external_created_at'=>$value->date_created
                            ]
                        );
                        //TODO: Revisar la integracion del campo external_additional_data
                        $createAccountServiceOrder->external_data = [$value];
                        $createAccountServiceOrder->external_additional_data = Json::encode(config('woodata'));
                        $createAccountServiceOrder->account_service_id =  $this->accountServiceId;
                        $createAccountServiceOrder->save();
                    }
                }

            },
            function (RequestException $e){
                Log::error($e->getMessage());
            }
        );
        return Utils::settle($results)->wait();

    }


}
