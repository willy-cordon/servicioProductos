<?php

namespace App\Services\MercadoLibre;

use App\Http\Clients\MlClient;
use App\Models\Account;
use App\Models\ExternalCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductServiceCategory;
use App\Models\ProductSync;
use App\Models\Service;
use App\Services\ProductSyncService;
use Eastwest\Json\Json;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Throwable;

final class MlProductService
{
    private  $mlClient;
    private  $serviceCurrency;
    private  $serviceCountry;
    private  $serviceLanguage;
    private  $beforeDescription;
    private  $afterDescription;
    private  $productSyncService;
    public function __construct($accountServiceId)
    {
        $this->mlClient = new MlClient($accountServiceId);
//        $service = Service::find($accountServiceId->service_id);
        $accountService = DB::table('account_service')
            ->leftJoin('services','services.id','=','account_service.service_id')
            ->where('account_service.id','=',$accountServiceId)
            ->first();
        $this->serviceCurrency = $accountService->currency_code;
        $this->serviceCountry = $accountService->country_code;
        $this->serviceLanguage = $accountService->language_code;
        $this->beforeDescription = $accountService->before_description;
        $this->afterDescription = $accountService->after_description;
        $this->productSyncService = new ProductSyncService();


    }

    public function getProduct($itemId)
    {
        $url =Str::replaceArray('{id}', [$itemId],config('api.ml_update_product.getItem'));
        $response = $this->mlClient->get($url);
        return $result = Json::decode($response->getBody());
    }


    public function create($productData,$productId,$productSyncId)
    {


        try {
            Log::debug('~~~~~~~~~~CREATE PRODUCT ML~~~~~~~~~~');
            $productData= Json::decode($productData);

            $searchCategoryQuery = ProductCategory::query();
            $searchCategoryQuery->leftJoin('product_service_categories','product_service_categories.product_category_id','=','product_categories.id');
            $searchCategoryQuery->leftJoin('external_categories','external_categories.id','=','product_service_categories.external_category_id');
            $searchCategoryQuery->where('product_categories.slug',$productData->category->{$this->serviceLanguage}->slug);
            $searchCategoryQuery->select(['external_categories.external_id']);
            $searchCategory = $searchCategoryQuery->first();


            /**
             * * Price mapping with service
             */
            $priceAr = '';
            foreach ($productData->price as $key => $price)
            {
                if ($key == $this->serviceCurrency)
                {
                    $priceAr = $price->value;
                }
            }
            /**
             * * List type mapping with Ml
             *
             */
            $listType = '';
            foreach (config('api.ml_list_types') as $key => $type)
            {
                if ($key == $productData->listing_type) {$listType = $type;}
            }

            /**
             * * Attribute mapping with Ml
             */
            $rewriteKeys = config('api.ml_attributes');
            $matchAttributes = array();

            foreach($productData->attributes as $key => $value) {
                if (array_key_exists($key,$rewriteKeys)){
                    $matchAttributes[$rewriteKeys[$key]] = $value;
                }
            }
            $attributes = [];
            foreach ($matchAttributes as $key2 => $value)
            {

                if (!empty($key2) ){
                    if (!empty($value->es))
                    {
                        $valor = $value->es ? $value->es : $value;
                        $attributes[]=['id'=>$key2,'value_name'=>$valor];
                    }else{
                        $attributes[]=['id'=>$key2,'value_name'=>$value];
                    }

                }

            }

            /**
             * *Prepare Json
             * ?ignore the description in the first post
             */
            $mlProductData['title'] = $productData->title;
            $mlProductData['category_id'] = $searchCategory->external_id;
            $mlProductData['available_quantity'] = $productData->available_quantity;
            $mlProductData['currency_id'] = $this->serviceCurrency;
            $mlProductData['price'] = $priceAr;
            $mlProductData['listing_type_id'] = $listType;
            $mlProductData['buying_mode'] = $productData->buying_mode;
            $mlProductData['condition'] = $productData->condition;
            $mlProductData['pictures'] = $productData->pictures;
            $mlProductData['attributes'] = $attributes;
//
            /**
             * *Add before and after for description services
             */
            $appendDescription = $this->beforeDescription."\n".$productData->description->plain_text."\n".$this->afterDescription;
            $description = ['plain_text'=>$appendDescription];


            /**
             * * Send product Ml
             */
            $promises[$productSyncId] = $this->mlClient->postAsync(
                config('api.ml_product.create_product'),
                [
                    'body'=> Json::encode($mlProductData)
                ]
            )->then(
                function(ResponseInterface $response) use ($description, $productSyncId, $productId, $productData) {
                    //Response 201 Created

                    $responseData = Json::decode($response->getBody());
                    Log::debug($response->getStatusCode());
                    Log::debug(Json::encode($responseData));
                    $createSuccess = false;
                    if($response->getStatusCode() == 201){
                        /**
                         * * Send description
                         * ! review documentation
                         */
                        $descriptionPost = $this->mlClient->post(
                            'https://api.mercadolibre.com/items/'.$responseData->id.'/description',
                            [
                                "body"=>Json::encode($description)
                            ]
                        );
                        Log::debug($descriptionPost->getStatusCode());
                        Log::debug($descriptionPost->getReasonPhrase());
                        /**
                         * *Save external id
                         */
                        DB::table('product_syncs')
                            ->where('id','=',$productSyncId)
                            ->update(['external_id'=> $responseData->id]);


                        $createSuccess = true;
                        Log::debug('producto creado correctamente');
                        Log::debug('------------------------');

                        return $createSuccess;
                    }else{
                        Log::debug('error');
                        return $createSuccess;
                    }

                },
                function (RequestException $e){
                    Log::error($e->getMessage());
                }
            );
            return $responses = Utils::settle($promises)->wait();

        }catch (Throwable $exception){
            report($exception);
            Log::debug($exception);
            return 'Error';
        }

    }

    public function update($itemId,$body,$productSyncId,$typeUpdate=false)
    {
        try {
            Log::debug('~~~~~~ Update ~~~~~~');
            $url =Str::replaceArray('{id}', [$itemId],config('api.ml_update_product.url'));
            $urlValue =Str::replaceArray('{value}', [$typeUpdate],$url);
            Log::debug($urlValue);
            $productData = Json::decode($body);
            Log::debug(Json::encode($productData));
            /**
             * * Price mapping with service
             */
            $priceAr = '';
            foreach ($productData->price as $key => $price)
            {
                if ($key == $this->serviceCurrency)
                {
                    $priceAr = $price->value;
                }
            }

            /**
             * * Attribute mapping with Ml
             */
            $rewriteKeys = config('api.ml_attributes');
            $matchAttributes = array();

            foreach($productData->attributes as $key => $value) {
                if (array_key_exists($key,$rewriteKeys)){
                    $matchAttributes[$rewriteKeys[$key]] = $value;
                }
            }
            $attributes = [];
            foreach ($matchAttributes as $key2 => $value)
            {

                if (!empty($key2) ){
                    if (!empty($value->es))
                    {
                        $valor = $value->es ? $value->es : $value;
                        $attributes[]=['id'=>$key2,'value_name'=>$valor];
                    }else{
                        $attributes[]=['id'=>$key2,'value_name'=>$value];
                    }

                }

            }

            $mlProductData['price'] = $priceAr;
            $mlProductData['available_quantity'] = $productData->available_quantity;
            $mlProductData['pictures'] = $productData->pictures;
            $mlProductData['attributes'] = $attributes;


            $promises[$productSyncId] = $this->mlClient->putAsync(
                $urlValue,
                [
                    'body' => Json::encode($mlProductData)
                ]
            )->then(
                function (ResponseInterface $response){

                    Log::debug($response->getStatusCode());
                    $createSuccess = false;
                    if($response->getStatusCode() == 200){

                        Log::debug('producto actualizado correctamente');
                        Log::debug('------------------------');

                        return $createSuccess;
                    }else{

                        return $createSuccess;
                    }
                },
                 function (RequestException $e){
                     Log::error($e->getMessage());
                 }
            );
            $responses = Utils::settle($promises)->wait();
            Log::debug($responses);
            return $responses;
        }catch (Throwable $exception){
            report($exception);
            Log::debug($exception);
            return 'Error';
        }
    }

    public function delete($itemId,$body,$productSyncId,$typeUpdate=false)
    {
        try {
            Log::debug('~~~~~~ Delete ~~~~~~');
            $url =Str::replaceArray('{id}', [$itemId],config('api.ml_update_product.url'));
            $urlValue =Str::replaceArray('{value}', [$typeUpdate],$url);
            $results[$productSyncId] = $this->mlClient->putAsync(
                $urlValue,
                [
                    'body' => Json::encode($body)
                ]
            )->then(
                function (ResponseInterface $response){

                    Log::debug($response->getStatusCode());
                    $createSuccess = false;
                    if($response->getStatusCode() == 200){

                        Log::debug('producto Eliminado correctamente');
                        Log::debug('------------------------');

                        return $createSuccess;
                    }else{

                        return $createSuccess;
                    }
                },
                function (RequestException $e){
                    Log::error($e->getMessage());
                }
            );
            $responses = Utils::settle($results)->wait();
            Log::debug($responses);
            return $responses;
        }catch (Throwable $exception){
            report($exception);
            Log::debug($exception);
            return 'Error';
        }
    }
}
