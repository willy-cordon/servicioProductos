<?php

namespace App\Services;

use App\Enums\WooStatus;
use App\Models\Account;
use App\Models\AccountServiceOrder;
use App\Models\Product;
use Broobe\Services\Service;
use Carbon\Carbon;
use Broobe\Services\Traits\{CreateModel, DestroyModel, ReadModel, UpdateModel};
use Eastwest\Json\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class AccountServiceOrderService extends Service
{
    use CreateModel, ReadModel, UpdateModel, DestroyModel;

    /**
     * Set model class name.
     *
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = AccountServiceOrder::class;
    }

    public function getDatatables(Request $request)
    {

        ## Read value
        $draw            = $request->get('draw');
        $start           = $request->get("start");
        $rowperpage      = $request->get("length");
        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');
        $dateInit        = $request->get('dataInit');
        $dateEnd         = $request->get('dataEnd');
        $columnIndex     = $columnIndex_arr[0]['column'];

        $searchColumns = [];
        if ( isset( $columnName_arr ) ) {
            for ( $i=0, $ien=count($columnName_arr) ; $i<$ien ; $i++ ) {
                $requestColumn = $request['columns'][$i];

                if(!$requestColumn['search']['value'] == NULL){
                    $searchColumns[$requestColumn['data']] =$requestColumn['search']['value'];
                }
            }
        }
        $columnName = str_replace('-', '.',$columnName_arr[$columnIndex]['data']);
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];
        $totalRecordsQuery = AccountServiceOrder::query();
        $totalRecordsQuery ->select('count(*) as allcount');


        $accountServiceOrderQuery = AccountServiceOrder::Query();
        $accountServiceOrderQuery->leftJoin('account_service', 'account_service.id', '=', 'account_service_orders.account_service_id');
        $accountServiceOrderQuery->where('account_service.id','=',$request->get('accountServiceId'));
        if ( $searchValue == WooStatus::All)
        {
            $searchValue = null;
        }
        if (!empty($searchValue))
        {
            $accountServiceOrderQuery->where('account_service_orders.external_status','=', $searchValue);
        }

        if (!empty($dateInit) && !empty($dateEnd) )
        {
            Log::debug($dateInit);
            Log::debug($dateEnd);
            $dateI = Carbon::createFromFormat(config('app.date_format'), $dateInit);
            $dateE = Carbon::createFromFormat(config('app.date_format'), $dateEnd);

            $accountServiceOrderQuery ->whereBetween('account_service_orders.external_created_at', [$dateI,$dateE]);
        }


        foreach ($searchColumns as $column => $value ){

            $db_column = str_replace('-', '.',$column);

            $accountServiceOrderQuery->where($db_column, 'like', '%' .$value . '%');

        }

        $totalRecords = $totalRecordsQuery->count();

        $accountServiceOrderQuery->select('account_service_orders.*');
        $accountServiceOrderQuery->orderBy($columnName,$columnSortOrder);

        $totalRecordswithFilter = $accountServiceOrderQuery->get()->count();

        if($rowperpage != -1){
            $accountServiceOrderQuery->skip($start);
            $accountServiceOrderQuery->take($rowperpage);
        }
        $accountServiceOrders = $accountServiceOrderQuery->get();

        $data_arr = array();

        $accountServiceTable = DB::table('account_service')
            ->where('id',$request->get('accountServiceId'))
            ->first();

        foreach ($accountServiceOrders as $key => $accountServiceOrder)
        {

            $products = Product::all();
            $clientName = '';
            $clientLastName = '';
            $clientDni = '';
            $clientEmail = '';
            $clientCodPhone = '';
            $clientPhone = '';
            $addressClientRef = '';
            $address = '';
            $addressNumber = '';
            $addressNumberCode = '';
            $addressFloor ='';
            $addressDepartment ='';
            $addressLocation='';
            $addressPostalCode='';
            $addressObservation='';
            $shippingName='';
            $weight='';
            $entrustName='';
            $height='';
            $width='';
            $depth='';
            $declaredValue='';





            foreach ($accountServiceOrder->external_data as $data)
            {

                $clientName = $data->billing->first_name;
                $clientLastName = $data->billing->last_name;
                $clientEmail = $data->billing->email;
                $clientPhone = $data->billing->phone;

                $address = $data->shipping->address_1;
                $addressNumber = $data->shipping->address_2;
                $addressLocation = $data->shipping->city;
                $addressPostalCode = $data->shipping->postcode;

                $addressObservation = $data->customer_note;

                foreach ($data->meta_data as $metaData)
                {
                    if ($metaData->key == '_billing_dni')
                    {
                        $clientDni = $metaData->value;
                    }
                }

                foreach ($data->line_items as $item)
                {
                    $products->each(function($product) use ($item,&$weight,&$height,&$width,&$depth,&$declaredValue) {
                       if ($item->sku == $product->product_code)
                       {
                           $weight=$product->product_data->sizes->weight;
                           $height=$product->product_data->sizes->height;
                           $width=$product->product_data->sizes->width;
                           $depth=$product->product_data->sizes->depth;
                           $declaredValue=$product->product_data->shippingOptions->declaredPrice;
                       }
                    });
                }
            }

            $weightConvert = $weight*1000;

            $data_arr[$key] = array(
                "any" => '',
                "product_weight" => $weightConvert ?? '',
                "entrust_name" => $entrustName ?? '',
                "product_height" => $height ?? '',
                "product_width" => $width ?? '',
                "product_depth" => $depth ?? '',
                "product_declared_value" => $declaredValue,
                "account_service_orders-external_order_id"  => $accountServiceOrder->external_order_id?? '',
                "data_client-first_name"                    => $clientName?? '',
                "data_client-last_name"                     => $clientLastName?? '',
                "data_client-dni"                           => $clientDni?? '',
                "data_client-email"                         => $clientEmail?? '',
                "data_client-phone"                         => $clientPhone?? '',
                "data_client-phone_code"                    => $clientCodPhone?? '',
                "data_address-ref"                          => $addressClientRef?? '',
                "data_address-address"                      => $address?? '',
                "data_address-number"                       => $addressNumber?? '',
                "data_address-floor"                        => $addressFloor?? '',
                "data_address-department"                   => $addressDepartment?? '',
                "data_address-location"                     => $addressLocation?? '',
                "data_address-postal_code"                  => $addressPostalCode?? '',
                "data_address-customer_note"                => $addressObservation?? '',
                "updated_at"                                => $accountServiceOrder->updated_at,
                "external_status"                           => $accountServiceOrder->external_status,
                "any2"=>''
            );
            if (!empty($accountServiceTable->enabled_order_fields) && !empty($accountServiceOrder->external_additional_data) )
            {

                $enabledOrderFields = Json::decode($accountServiceTable->enabled_order_fields, true);
                $externalAdditional = Json::decode($accountServiceOrder->external_additional_data, true);


                foreach ($enabledOrderFields as $keyEnabled => $enabledOrderField)
                {
                    $data_arr[$key][$keyEnabled] = isset($externalAdditional[$keyEnabled]) ? $externalAdditional[$keyEnabled] : '' ;
                }

            }

        }
            Log::debug($data_arr);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return $response;
    }

    public function ordersByService($serviceId): array
    {
        $userLogged = Auth::guard('sanctum')->user();
        $ac = DB::table('account_service')
            ->where('account_id',$userLogged->account_id)
            ->where('service_id',$serviceId)
            ->first();

        $orders = AccountServiceOrder::where('account_service_id',$ac->id)->get();
        $result = [];
        $orders->each(function($order) use(&$result){
            /**
             * * Mapear las ordenes
             * ? Formar el excel?
             */
            foreach ($order->external_data as $data)
            {
                $clientDni= '';
                foreach ($data->meta_data as $metaData)
                {
                    if ($metaData->key == '_billing_dni')
                    {
                        $clientDni = $metaData->value;
                    }
                }
                /**
                 * * Line items
                 * ! Buscar el producto por el sku?
                 */
                foreach ($data->line_items as $item){
                    if(!empty($item->sku))
                    {
                        Log::debug('sku para el producto');
                        Log::debug($item->sku);
                    }
                }


                $result[] = [
                    'id'=>$order->external_order_id,
                    'status'=>$data->status,
                    'currency'=>$data->currency,
                    'date_created'=>$data->data_craeted,
                    'date_modified'=>$data->data_modified,
                    "discount_total" => $data->discount_total,
                    "discount_tax" => $data->discount_tax,
                    "shipping_total" => $data->shipping_total,
                    "shipping_tax" => $data->shipping_tax,
                    "cart_tax"=> $data->cart_tax,
                    "total"=> $data->total,
                    "total_tax"=> $data->total_tax,
                    "customer_id"=> $data->customer_id,
                    "order_key"=> $data->order_key,
                    'billing'=>[
                        'name'=>$data->billing->first_name,
                        'last_name'=>$data->billing->last_name,
                        "company"=> $data->billing->company,
                        'dni'=>$clientDni,
                        "country"=> $data->billing->country,
                        'email'=> $data->billing->email,
                        'phone'=> $data->billing->phone,

                    ],
                    'shipping'=>[
                        'address1'=>$data->shipping->address_1,
                        'address2'=>$data->shipping->address_2,
                        'city'=>$data->shipping->city,
                        'state'=>$data->shipping->state,
                        'postcode'=>$data->shipping->postcode,
                        'customer_note'=>$data->customer_note
                    ],
                    "payment_method"=> $data->payment_method,
                    "payment_method_title"=> $data->payment_method_title,
                    "transaction_id"=> $data->transaction_id,
                    "customer_ip_address"=> $data->customer_ip_address,
                    "customer_user_agent"=> $data->customer_user_agent,
                    "created_via"=> $data->created_via,
                    "customer_note"=> $data->customer_note,
                    "date_completed"=> $data->date_completed,
                    "date_paid"=> $data->date_paid,
                    "cart_hash"=> $data->cart_hash,
                    "number"=> $data->number,
                ];
            }

        });


        return $result;
    }
}
