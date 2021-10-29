<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Account;
use App\Models\Product;
use App\Models\User;
use Broobe\Services\Service;
use Broobe\Services\Traits\{CreateModel, DestroyModel, ReadModel, UpdateModel};
use Eastwest\Json\Json;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class AccountService extends Service
{
    use CreateModel, ReadModel, UpdateModel, DestroyModel;

    /**
     * Set model class name.
     *
     * @return void
     */
    protected $serviceService;
    private $mlCliente;
    protected function setModel(): void
    {
        $this->model = Account::class;
        $this->serviceService = new ServiceService();
    }

    public function all(): Collection
    {
        return $this->model::withTrashed()->get();
    }

    public function accountUser()
    {
        $userLogged = User::find(auth()->user()->id);
        return Account::find($userLogged->account_id);
    }

    public function restore($id)
    {
        Log::debug($id);
        return $this->model::withTrashed()->find($id)->restore();
    }

    public function create(Request $request): Model
    {
        $createService = Account::create(['name'=>$request->get('name')]);

        /**
         * * Asociamos los servicios seleccionados
         */
        if ($request->has('services'))
        {
            foreach ($request->get('services') as $key => $value)
            {
                 if ($value == 'on')
                 {
                    $service = \App\Models\Service::find($key);
                    $createService->services()->sync([$service->id],false);
                 }
            }
        }
        if (auth()->user()->hasRole(User::ROLE_CLIENT))
        {
            $user= User::find(auth()->user()->id);
            $user->account()->associate(Account::find($createService->id))->save();
        }

        return $createService;
    }

    public function update(Model $model, Request $request): \Illuminate\Database\Eloquent\Builder
    {

        $updateAccount = Account::query();
        $updateAccount->where('id',$model->id);
        $updateAccount->update(['name'=>$request->get('name')]);

        /**
         * *Actualizamos el estado en la tabla pivot
         */
        if (!empty($request->get('status')))
        {
            foreach ($request->get('status') as $key => $value)
            {
                DB::table('account_service')
                    ->where('id','=',$key)
                    ->update(['status'=>$value == 'on' ? 1 : $value]);
            }
        }

        /**
         * * Asociamos los servicios seleccionados
         */
        $account = Account::find($model->id);
        if ($account->services()->withTimestamps == false )
        {
            foreach ($request->get('services') as $key => $value)
            {
                if ($value == 'on')
                {
                    $service = \App\Models\Service::find($key);
                    $account->services()->sync([$service->id],false);
                }
            }
        }

        /**
         * * Borramos el servicio de la tabla pivot
         * !Borra el registro de la tabla pivot
         */
        $arr=[];
        foreach ($request->get('services') as $key => $value)
        {
            foreach ($model->services as $service)
            {
                $arr[]=$service->pivot->service_id;
                if ($service->pivot->service_id == $key && $value == '0')
                {
                    /**
                     * *Enviamos la nofificacion que el servicio no esta disponible
                     */

                    $accountService = DB::table('account_service')
                                        ->where('account_id','=',$model->id)
                                        ->where('service_id','=',$key)
                                        ->first();
                    $client = new Client();
                    $response = $client->post(
                        "http://localhost:5000/clients",
                        [
                            'form_params'=> [
                                'nombre'=>'creado desde laravel',
                                'apellido'=>'200',
                                'empresa'=>'1629998376415.jpg',
                                'email'=>'1629998376415.jpg',
                                'telefono'=>'1629998376415.jpg',
                            ]
                        ]
                    );
                    Log::debug($response->getBody());
                    $accountService->delete();

                }

            }
        }
        $data = array_unique($arr);
        /**
         * * Agregamos los servicios
         * ? No tiene estado por defult
         */
        foreach ($request->get('services') as $key => $value)
        {
            foreach ($data as $dat)
            {
                if ($key != $dat && $value == 'on')
                {
                    $service = \App\Models\Service::find($key);
                    $account = Account::find($model->id);
                    $account->services()->sync([$service->id],false);
                }
            }

        }

        if ($request->get('before_description') != null)
        {
            DB::table('account_service')
                ->where('id','=',$request->get('service_id_before'))
                ->update(['before_description'=>$request->get('before_description')]);
        }
        if ($request->get('after_description') != null)
        {
            DB::table('account_service')
                ->where('id','=',$request->get('service_id_after'))
                ->update(['after_description'=>$request->get('after_description')]);
        }


        if ($request->get('external_client_id') != null)
        {
            DB::table('account_service')
                ->where('id','=',$request->get('service_id_client_id'))
                ->update(['external_client_id'=>$request->get('external_client_id')]);
        }

        if ($request->get('external_client_secret') != null)
        {
            DB::table('account_service')
                ->where('id','=',$request->get('service_id_secret'))
                ->update(['external_client_secret'=>$request->get('external_client_secret')]);
        }


        if ($request->get('external_url') != null)
        {
            DB::table('account_service')
                ->where('id','=',$request->get('service_id_url'))
                ->update(['external_url'=>$request->get('external_url')]);
        }

        /**
         * *Recorremos los campos que seleccionaron para el available orders
         */

        if ($request->has('availableOrders'))
        {
            Log::debug($request->get('availableOrders'));
            $availableOrderFieldRequests = $request->get('availableOrders');
//            Log::debug($availableOrderFieldRequests);
            $saveAvailableOrderFields = [];
            foreach (\App\Models\Service::availableOrderFields as $key => $availableOrderField)
            {
                Log::debug($key);
                foreach ($availableOrderFieldRequests as $availableOrderFieldRequest)
                {
                    if ($key == $availableOrderFieldRequest)
                    {
                        $saveAvailableOrderFields[$key]= $availableOrderField;
                    }
                }
            }

            DB::table('account_service')
                ->where('id','=',$request->get('service_id_url'))
                ->update(['enabled_order_fields'=> $saveAvailableOrderFields]);
        }

        return $updateAccount;

    }

    public function disconnectMl($request)
    {
        $responseStatus = false;
        try {
            DB::table('account_service')
                ->where('id','=',$request->get('id'))
                ->update(['token'=>null,'refresh_token'=>null,'status'=>Status::Inactive,'token_type'=>null,'scope'=>null,'user_id'=>null]);
        $responseStatus = true;
        }catch (\Throwable $exception)
        {
            Log::warning($exception);
        }
        return $responseStatus;
    }

    public function destroy(Model $model): \Illuminate\Database\Eloquent\Builder
    {
        /**
         * * Borramos todos los productos y los productSyncs de la cuenta
         */
        $deleteProducts = Product::query();
        $deleteProducts->leftJoin('product_syncs','product_syncs.product_id','=','products.id');
        $deleteProducts->where('account_id','=',$model->id);
        $deleteProducts->delete();

        /**
         * * Borramos todos los account service y las ordenes asociados a ese account service
         */
        $accountService = DB::table('account_service')
            ->leftJoin('account_service_orders','account_service_orders.account_service_id','=','account_service.id')
            ->where('account_id','=',$model->id)
            ->delete();

        /**
         * *Borramos la cuenta del usuario
         */
        $userAccount = User::query();
        $userAccount->where('account_id',$model->id);
        $userAccount->update(['account_id'=>null]);


        $deleteAccount = Account::query();
        $deleteAccount->where('id',$model->id);
        $deleteAccount->delete();

        return $deleteAccount;
    }

}
