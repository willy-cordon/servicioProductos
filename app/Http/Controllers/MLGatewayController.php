<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\MercadoLibre\MLCheckExistingProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class MLGatewayController extends Controller
{

    public function callbackHandler(Request $request)
    {

        try {
            $account_service = DB::table('account_service')->where('id',$request->get('state'))->first();
            $service = Service::find($account_service->service_id);

            /**
             * * Auth con Ml para obtener el token,refresh tokeny user id
             */
            $response = Http::asForm()->post(config('api.ml_oauth_token.url'),[
                'grant_type'=>'authorization_code',
                'client_id'=>$service->client_id,
                'client_secret'=>$service->client_secret,
                'code'=>$request->get('code'),
                'redirect_uri'=>config('api.callback_url_app.url')
            ]);


            if ($response->successful()){
                /**
                 * * Si el login fue exitoso obtenemos las credenciales para poder operar con ellas
                 */

                DB::table('account_service')
                    ->where('id',$request->get('state'))
                    ->update([
                        'token'         =>$response->json('access_token'),
                        'token_type'    =>$response->json('token_type'),
                        'scope'         =>$response->json('scope'),
                        'user_id'       =>$response->json('user_id'),
                        'refresh_token' =>$response->json('refresh_token'),
                    ]);
                /**
                 * * Verificamos y comparamos productos de ml con nuestra base
                 * ! Desactivar el servicio en account service
                 */
                $checkProductsExists = new MLCheckExistingProducts($account_service->id);
                $checkProductsExists->checkProducts();


                return redirect('/commons/accounts/'.$account_service->account_id.'/edit')->withSuccess('Conectado a mercado libre correctamente');
            }else{
                return redirect('/commons/accounts/'.$account_service->account_id.'/edit')->withFail('Error al conectarse');
            }
        }catch (Throwable $exception){
            report($exception);
            return Redirect::back()->withFail('Error!');
        }



    }
}
