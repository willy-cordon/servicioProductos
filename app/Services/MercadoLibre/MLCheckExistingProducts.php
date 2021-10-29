<?php

namespace App\Services\MercadoLibre;

use App\Enums\ProductSyncAction;
use App\Enums\ProductSyncStatus;
use App\Http\Clients\MlClient;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductSync;
use Eastwest\Json\Json;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

final class MLCheckExistingProducts
{

    /**
     * MLCheckExistingProducts constructor.
     */
    private $mlClient;
    private $userId;
    private $token;
    private $tokenType;
    private $accountId;
    private $accountServiceId;
    public function __construct($accountServiceId)
    {
        $this->mlClient = new MlClient($accountServiceId);
        $accountService = DB::table('account_service')
            ->where('account_service.id','=',$accountServiceId)
            ->first();
        $this->userId = $accountService->user_id;
        $this->token = $accountService->token;
        $this->tokenType = $accountService->token_type;
        $this->accountId = $accountService->account_id;
        $this->accountServiceId = $accountServiceId;

    }


    public function checkProducts()
    {

        try {
            Log::debug('////////Check Products///////////');
            /**
             * * Traemos todos los productos segun la cuenta y el servicio del usuario
             */
            $productsQuery = Product::query();
            $productsQuery->leftJoin('product_syncs','product_syncs.product_id','=','products.id');
            $productsQuery->where('products.account_id',$this->accountId);
            $productsQuery->where('product_syncs.account_service_id',$this->accountServiceId);
            $productsQuery->select(['product_syncs.id as productSyncId','products.id as productId','products.product_code']);
            $products = $productsQuery->get();


            /**
             * * Obtenemos todos los items del usuario en ML
             */
            $url =Str::replaceArray('{user_id}', [$this->userId],config('api.ml_search_items.search_items'));
            $response = $this->mlClient->get(
                $url
            );
            $responseData = Json::decode($response->getBody());

            if($response->getStatusCode() == 200){
                $this->updateProductSync($products,$responseData);
                $this->checkProductScrollId($responseData->scroll_id,$url,$products);
            }

        }catch (Throwable $exception){
            report($exception);
            Log::debug($exception);
            return 'Error';
        }
    }

    public function checkProductScrollId($scrollId,$url,$products)
    {
        Log::debug('///////////////////////// SCROLL_ID /////////////////');
        $response = $this->mlClient->get(
            $url.'&scroll_id='.$scrollId
        );
        $responseData = Json::decode($response->getBody());

        if (count($responseData->results) > 0)
        {
            $this->checkProductScrollId($scrollId,$url,$products);
        }

        if($response->getStatusCode() == 200){
            $this->updateProductSync($products,$responseData);
        }

    }
    public function updateProductSync($products,$responseData)
    {
        foreach ($responseData->results as $value)
        {
            /**
             * * Obtenemos toda la informacion del item
             * ? Se realiza este llamado para obtener el SKU o ISBN
             */
            $responseItem = $this->mlClient->get(
                "https://api.mercadolibre.com/items/".$value
            );
            $responseDataItem = Json::decode($responseItem->getBody());
            foreach ($responseDataItem->attributes as $responseItem)
            {
                /**
                 * * Verficamos si el sku o isbn son iguales a algun producto de la base de market y actualizamos el external_id
                 */
                if ($responseItem->id === 'SELLER_SKU')
                {
                    $products->each(function($product) use (&$count, &$productSync, &$responseDataItem, &$responseItem) {
                        if ($product->product_code == $responseItem->value_name)
                        {
                            $productSync = ProductSync::query();
                            $productSync->where('id','=',$product->productSyncId);
                            $productSync->whereNull('external_id');
                            $productSync->update(['external_id'=>$responseDataItem->id, 'status'=>ProductSyncStatus::synced, 'action'=>ProductSyncAction::create]);
                        }
                    });


                }
            }

        }
    }

}

