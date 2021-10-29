<?php


namespace App\Http\Clients;


use App\Models\Service;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MlClient extends Client
{
    private $account_service;
    private $access_token;

    public function __construct($accountService)
    {
        $this->account_service = $accountService;

        $accountServiceData = DB::table('account_service')->where('id',$this->account_service)->first();
        $this->access_token = $accountServiceData->token;


        $stack = new HandlerStack();
        $stack->setHandler(Utils::chooseHandler());
        $stack->push(Middleware::retry(
            function (
                $retries,
                Request $request,
                Response $response = null,
                RequestException $exception = null
            ) {
                $maxRetries = 1;
                if ($retries >= $maxRetries) {
                    return false;
                }
                if ($response && $response->getStatusCode() === 401) {
                    Log::debug( 'entra al 401');
                    $this->refreshClientAccessToken();
                    return true;
                }
                return false;
            }
        ));

        // mapRequest ALWAYS adds a Authentication header (if Request contains a "X-Token: Add" header
        // getClientAccessToken() should get the current token from the storage/cache and add it
        $stack->push(Middleware::mapRequest(function (Request $request) {
            $request = $request->withHeader('Accept','application/json');
            $request = $request->withHeader('Content-Type','application/json; charset=utf-8');
            return $request->withHeader('Authorization', 'Bearer ' .$this->access_token);
        }));

        $config = [
            'handler' => $stack,
        ];
        parent::__construct($config);
    }

    private function refreshClientAccessToken()
    {
        //ServiceId save client y client secret
        //TODO: Manejar Errores x2
        $accountServiceData = DB::table('account_service')->where('id',$this->account_service)->first();
        $service = Service::where('id',$accountServiceData->service_id)->first();
        Log::debug('en el refresh');
Log::debug($service);
        $response = Http::asForm()->post(config('api.ml_oauth_token.url'),[
            'grant_type'=>'refresh_token',
            'client_id'=>$service->client_id,
            'client_secret'=>$service->client_secret,
            'refresh_token'=>$accountServiceData->refresh_token
        ]);

        if($response->successful()){
            Log::debug($response->body());
            $this->access_token = $response->json('access_token');
            DB::table('account_service')->where('id',$accountServiceData->id)
                ->update(["token"=> $this->access_token, "refresh_token" => $response->json('refresh_token') ]);
        }else{
            $response->throw();
        }

    }

}
