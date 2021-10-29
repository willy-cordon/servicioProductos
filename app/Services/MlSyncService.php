<?php

namespace App\Services;

use App\Enums\MLStatus;
use App\Enums\ProductSyncAction;
use App\Http\Clients\MlClient;
use App\Models\User;
use App\Services\MercadoLibre\MlProductService;
use Eastwest\Json\Json;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

final class MlSyncService
{
    //Construnct MlproductrService

    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function syncroniceProducts($accountServiceId=''): string
    {
        if (empty($accountServiceId))
        {
         $accountServiceDb = DB::table('account_service')->get();
        }else{

            $accountServiceDb = DB::table('account_service')
                ->where('account_id','=',$accountServiceId)
                ->get();
        }
        $accountServiceDb->each(function ($accountService){
            $mlProductService= new MlProductService($accountService->id);
            /**
             * * Execute method delete
             */
            $this->delete($accountService, $mlProductService);
            /**
             * * Execute method update
             */
            $this->update($accountService, $mlProductService);
            /**
             * * Execute method create
             */
            $this->create($accountService, $mlProductService);
        });

        return 'ok';
    }


    public function delete(  $accountService, MlProductService $mlProductService): string
    {
        try {
            Log::debug('delete method');
            $pendingProducts = $this->productService->getPending(ProductSyncAction::delete, $accountService);


            $body = ['status'=>MLStatus::Closed];

            if (!empty($pendingProducts)){
                $pendingProducts->each(function($product)use($mlProductService,$body, &$returnResponse) {
                    if (!empty($product->external_id))
                    {
                        $deleteProduct = $mlProductService->delete($product->external_id, $body,$product->prodSync);
                        if ($deleteProduct)
                        {
                            ProductSyncService::synced($product);
                        }
                    }
                });
            }
            return 'ok';
        }catch (\Throwable $exception)
        {
            report($exception);
            return 'error';
        }


    }



    public function create( $accountService,MlProductService $mlProductService)
    {
        try {
        Log::debug('update method');
            $pendingProducts = $this->productService->getPending(ProductSyncAction::create, $accountService);
            $pendingProducts->each(function($product)use($mlProductService){

                $sendProductMl = $mlProductService->create(Json::encode($product->product_data),$product->id,$product->prodSync);
                //Si ocurre un error el estado del product sync no cambia
                Log::debug($sendProductMl);
                if ($sendProductMl){
                    ProductSyncService::synced($product);
                }
            });
            return 'ok';
        }catch (\Throwable $exception)
        {
            report($exception);
            return 'error';
        }


    }

    public function updateTitle($itemId,$body,$typeUpdate='')
    {

        //TODO: no es permitido cambiar el titulo si el item posee ventas "sold_quantity" = 0

        $productData = $this->mlProductService->getProduct($itemId);
        $productData->sold_quantity;
//        Log::debug(Json::encode($productData));
        /**
         * !
         * !Cuando el artículo tiene ventas, no podrás cambiar ninguno de los siguientes campos:
         * !Título
         * !Modo de compra
         * !Métodos de Pago distintos de Mercado Pago
         */
        if ($productData->sold_quantity == 0 && $productData->status != MLStatus::Inactive){
//            $body = '{
//                      "title": "Actualizando titulo bis",

//                    }';
            $this->mlProductService->update($itemId,$body,$typeUpdate);
        }

    }
    /*
     * Se puede actualizar los campos que se envien exeptuando:
     * Available_quantity,precio,video,Imágenes,Descripción,Envío
     * @required status:active
     *
     * Attributes:{ "attributes": [{
      !"id": "Name_Attribute",
      !"value_name": "value_attribute"}]}
     * */
    public function update($accountService, MlProductService $mlProductService)
    {
        try {
            Log::debug('update method');
            $pendingProducts = $this->productService->getPending(ProductSyncAction::update, $accountService);

            $pendingProducts->each(function($product) use($mlProductService){
                Log::debug($product);

                $productData = $mlProductService->getProduct($product->external_id);
                if ($productData->status == MLStatus::Active){
//                    return $this->mlProductService->update($itemId,$body,$productSyncId);
                    $updateProductMl = $mlProductService->update($product->external_id,Json::encode($product->product_data),$product->prodSync);
                    //Si ocurre un error el estado del product sync no cambia
                    if ($updateProductMl){
                        ProductSyncService::synced($product);
                    }
                }
            });
            return 'ok';
        }catch (\Throwable $exception)
        {
            report($exception);
            return 'error';
        }

    }


}
