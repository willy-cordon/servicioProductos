<?php

namespace App\Services\MercadoLibre;

use App\Http\Clients\MlClient;
use App\Models\ExternalCategory;
use App\Models\Service;
use Eastwest\Json\Json;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

final class MLCategorySyncService
{
    private $mlClient;
    private $service;
    public function __construct(MlClient $mlClient, Service $service)
    {
        $this->mlClient = $mlClient;
        $this->service = $service;
    }

    public function updateCategory()
    {
        try {

            $response = $this->mlClient->get(config('api.ml_categories.'.$this->service->country_code));
            $MLCategories = Json::decode($response->getBody());

            foreach ($MLCategories as $key => $category)
            {
                $parents = $category->path_from_root;
                $parent = '';
                if(is_array($parents)){
                    if(count($parents) > 1){
                        $parent = $parents[count($parents)-2];
                    }
                }
                $parentId = '';
                if (!empty($parent)){

                    $parentId = $parent->id;
                }

               $createProductSync =  ExternalCategory::updateOrCreate(
                    [
                        'external_id' => $category->id,
                        'service_id'=> $this->service->id
                    ],
                    [
                        'external_id' => $category->id,
                        'service_id'=> $this->service->id,
                        'external_name' => $category->name,
                        'external_parent_id'=>$parentId
                    ]
                );

                if ($createProductSync->wasRecentlyCreated){
                    Log::debug('create');
//                    $createProductSync->action = ProductSyncAction::create;
                }else{
                    Log::debug('update');

//                    $createProductSync->action = ProductSyncAction::update;
                }

            }
            return 'ok';
        } catch (GuzzleException $e) {
            report($e);
            return 'error';
        }

    }
}
