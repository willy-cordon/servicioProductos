<?php

namespace App\Services;

use App\Enums\ProductSyncAction;
use App\Enums\ProductSyncStatus;
use App\Enums\Status;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductServiceCategory;
use App\Models\ProductSync;
use App\Models\User;
use App\Models\Service as ServiceModel;
use Broobe\Services\Service;
use Broobe\Services\Traits\{CreateModel, DestroyModel, ReadModel, UpdateModel};
use Eastwest\Json\Json;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\IFTTTHandler;
use Throwable;

final class ProductService extends Service
{
    use CreateModel, ReadModel, UpdateModel, DestroyModel;
    const DEFAULTCURRENCY = 'ARS';
    const DEFAULTLANGUAGE = 'es';

    /**
     * Set model class name.
     *
     * @return void
     */
    private $productSyncService;
    private $accountService;
    private $accountServiceService;
    protected function setModel(): void
    {
        $this->model = Product::class;
        $this->productSyncService = new ProductSyncService();
        $this->accountService = new AccountService();

        $this->accountServiceService = new AccountServiceService();
    }


    public function create($request,$serviceId=''): array
    {
        Log::debug('~~~~~~~~~~~~~~~ CREATE PRODUCT ~~~~~~~~~~~');
        $productCodeResult = '';
            try {
                $result = [];
                $data = Json::decode($request);

                $userLogged = Auth::guard('sanctum')->user();

                $serviceIdVerify = false;
                //verificamos si se recibo el serviceId
                if (!empty($serviceId)){
                    $serviceIdVerify = true;
                    $accountServiceData = $this->accountServiceService->getIfActive($userLogged->account_id,$serviceId);
                }else{
                    $accountServiceData = $this->accountServiceService->getAllActiveForAccount($userLogged->account_id);
                }
                !empty($data->product_code) ? $productCodeResult=$data->product_code : $productCodeResult='NAN';
                //Verificamos que no este vacio los accountService
                if (!empty($accountServiceData)) {
                    //Verficamos que dentro de la data recibida se encuentren los campos obligatorios
                    if (!empty($data->product_code) && !empty($data->catalog_code) )
                    {
                        $createProduct = Product::updateOrCreate(
                            [
                                'account_id' => $userLogged->account_id,
                                'product_code' => $data->product_code,
                                'catalog_code' => $data->catalog_code
                            ],
                            [
                                'product_code' => $data->product_code,
                                'catalog_code' => $data->catalog_code
                            ]);

                        $createProduct->product_data = Json::encode($data->product_data);
                        $createProduct->account()->associate(Account::find($userLogged->account_id))->save();
                          //TODO: revisar el external_categories exiten dos tipos de libros con distinto parent
//
                        $languageServices = DB::table('account_service')
                            ->leftJoin('services','services.id','=','account_service.service_id')
                            ->where('account_id','=',auth()->user()->account_id)
                            ->select(['services.language_code'])
                            ->get();


                        foreach ($languageServices as $language)
                        {
                            if (!empty($language->language_code))
                            {
                                 ProductCategory::updateOrCreate(
                                    ['slug' => $data->product_data->category->{$language->language_code}->slug],
                                    [
                                        'slug' => $data->product_data->category->{$language->language_code}->slug,
                                        'name' => $data->product_data->category->{$language->language_code}->name
                                    ]
                                );
                            }
                        }


                        //TODO revisar logica al crear product sync
                        //Verificamos si se trata de un solo servicio o de todos(associados al account del usuario)
                        if ($serviceIdVerify)
                        {
                            $this->createProductSync($createProduct,$accountServiceData);
                        }else{
                            $accountServiceData->each(function($data) use ($createProduct) {
                                $this->createProductSync($createProduct,$data);
                            });
                        }
                        $result[$productCodeResult] = ['status'=>'ok'];
                    }else{

                        $result[$productCodeResult] = ['status'=>'error','message'=>'faltan datos requeridos'];
                    }


                }else{

                    $result[$productCodeResult] = ['status'=>'Error'];
                }

            }catch(Throwable $exception){
                report($exception);
                $result[$productCodeResult] = ['status' => 'error', 'message' => $exception->getMessage()];
            }




        return $result;
    }

    public function createProductSync($createProduct,$accountServiceData)
    {
        $createProductSync = ProductSync::updateOrCreate(
            [   'product_id' => $createProduct->id,
                'account_service_id' => $accountServiceData->id],
            [
                'status' => ProductSyncStatus::pending
            ]
        );
        if ($createProductSync->wasRecentlyCreated){
            $createProductSync->action = ProductSyncAction::create;
        }else{
            if ($createProductSync->action == ProductSyncAction::delete)
            {
                $createProductSync->action = ProductSyncAction::create;
            }else{
                $createProductSync->action = ProductSyncAction::update;
            }
        }
        $createProductSync->product()->associate(Product::find($createProduct->id));
        $createProductSync->account_service_id = $accountServiceData->id;
        $createProductSync->save();

        return $createProductSync;
    }

    public function bulkCreateProduct($request,$serviceId='')
    {

        $products = collect($request);
        $message = [];
        $products->each(function ($product) use ($serviceId, &$message) {
          $dataToSend =  $this->create(Json::encode($product),$serviceId);
          $message[] = $dataToSend;
        });

        return $message;
    }

    public function bulkDeleteProduct($request,$serviceId='')
    {
        $products = collect($request);
        $message = [];
        $products->each(function ($product) use ($serviceId, &$message) {
            $dataToSend =  $this->delete(Json::encode($product),$serviceId);
            $message[] = $dataToSend;
        });

        return $message;
    }

    public function delete($request,$serviceId=''): array
    {
        $result= [];
        try {
            Log::debug('~~~~~~~~~ request delete ~~~~~');
            Log::debug($request);
            $productData = Json::decode($request);
            //Verificamos si llega la data
            if (!empty($productData)){
                //Verificamos que los datos requeridos esten dentro de la data
                if (!empty($productData->product_code) && !empty($productData->catalog_code) )
                {
                    $userLogged = Auth::guard('sanctum')->user();
                    $product = Product::where('account_id',$userLogged->account_id)->where('product_code',$productData->product_code)->where('catalog_code',$productData->catalog_code)->first();
                    if (!$product)
                    {
                       return ['status'=>'error', 'message'=>'product_code o catalog_code incorrectos'];
                    }
                    $updateProductService = ProductSync::query();
                    $updateProductService->where('product_id',$product->id);
                    //Verificamos si llega el serviceId por url
                    if (!empty($serviceId)){
                        $accountServiceData = $this->accountServiceService->getIfActive($userLogged->account_id,$serviceId);
                        //Verificamos que la consulta no de vacia
                        if (!empty($accountServiceData)){
                            $updateProductService->where('account_service_id',$accountServiceData->id);
                            $updateProductService->update(['action'=>ProductSyncAction::delete, 'status'=>ProductSyncStatus::pending]);
                            $result = ['status'=>'ok'];
                        }else{
                            $result[] = ['status'=>'error'];
                        }
                    }else{
                        $updateProductService->update(['action'=>ProductSyncAction::delete, 'status'=>ProductSyncStatus::pending]);
                        $result = ['status'=>'ok'];
                    }


                }else{
                    $result = ['status'=>'error','message'=>'faltan datos requeridos'];
                }

            }else{
                $result = ['status'=>'error','message'=>'sin data'];
            }


        }catch (Throwable $exception){
            report($exception);
            $result[] = ['status' => 'error', 'message' => $exception->getMessage()];
        }
        return $result;
    }


    public function getPending($action, $accountService)
    {

                $productSyncPendingQuery = Product::query();
                $productSyncPendingQuery->leftJoin('product_syncs','product_syncs.product_id','=','products.id');
                 $productSyncPendingQuery->where('product_syncs.account_service_id',$accountService->id);
                 $productSyncPendingQuery->where('product_syncs.status',ProductSyncStatus::pending);
                 $productSyncPendingQuery->where('product_syncs.action',$action);
                 $productSyncPendingQuery->where('product_syncs.status',Status::Active);
                 $productSyncPendingQuery->select(['products.id','product_syncs.id AS prodSync','product_syncs.account_service_id','product_syncs.external_id','products.product_data']);

                  $productSyncPending = $productSyncPendingQuery->get();
//                  Log::debug($productSyncPending);
            return $productSyncPending;




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
        $accountId      = $request->get('accountId');
        $columnIndex     = $columnIndex_arr[0]['column'];



        $columnName = str_replace('-', '.',$columnName_arr[$columnIndex]['data']);
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];
        $totalRecordsQuery = Product::query();
        $totalRecordsQuery->where('account_id','=',$accountId);

        $totalRecordsQuery ->select('count(*) as allcount');
        $productQuery = Product::Query();

        if (!empty($searchValue))
        {
            $productQuery->orWhere('products.product_code', 'like', '%' .$searchValue . '%');
            $productQuery->orWhere('products.catalog_code', 'like', '%' .$searchValue . '%');
        }
        $productQuery->where('account_id','=',$accountId);


        $totalRecords = $totalRecordsQuery->count();

        $productQuery->select('products.*');
        $productQuery->orderBy($columnName,$columnSortOrder);

        $totalRecordswithFilter = $productQuery->get()->count();

        if($rowperpage != -1){
            $productQuery->skip($start);
            $productQuery->take($rowperpage);
        }
        $products = $productQuery->get();

        $data_arr = array();

        foreach ($products as $product)
        {
//            Log::debug($product);
         $productTitle = '';
         $valueCurrency = '';
         $categoryName = '';
         $productQuantity = '';
            foreach ($product->product_data as $key => $data)
            {

                if ($key == 'title')
                {
                 $productTitle = $data;
                }
                if ($key == 'available_quantity')
                {
                    $productQuantity = $data;
                }
                if ($key == 'price'){
                    foreach ($data as $currency)
                    {
//
                        if ($currency->currency == self::DEFAULTCURRENCY)
                        {
//                            Log::debug(Json::encode($currency));
                            $valueCurrency = $currency->value;
                        }
                    }
                }
                    if ($key == 'category')
                    {
                        foreach ($data as $key2 => $category)
                        {
//
                            if ($key2 == self::DEFAULTLANGUAGE)
                            {
                                $categoryName = $category->name;
                            }
                        }
                    }

            }


            $data_arr[] = array(
                "any" => '',
                "products-id" => $product->id,
                'products-product_code' => $product->product_code,
                'products-catalog_code' => $product->catalog_code,
                'products-title' => $productTitle,
                'products-price' => $valueCurrency,
                'products-category' => $categoryName,
                'products-quantity' => $productQuantity,

            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return $response;
    }




}
