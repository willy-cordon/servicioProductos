<?php

namespace App\Http\Controllers;

use App\Models\ProductSync;
use Eastwest\Json\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductSyncController extends Controller
{

    public function indexML($id)
    {
      $productSyncQuery = ProductSync::query();
        $productSyncQuery->leftJoin('account_service','account_service.id','=','product_syncs.account_service_id');
        $productSyncQuery->where('account_service.id','=',$id);
        $productSyncQuery->select(['product_syncs.id','product_syncs.status','product_syncs.action','product_syncs.product_id','product_syncs.account_service_id']);

//      $productSyncQuery = ProductSync::query();
//      $productSyncQuery->leftJoin('account_service','account_service.id','=','product_syncs.account_service_id');
//      $productSyncQuery->where('account_service.id','=',$id);
//      $productSyncQuery->select(['product_syncs.id','product_syncs.status','product_syncs.action']);
      $products = $productSyncQuery->get();
      Log::debug($products);

//      $data = Json::decode($products);
//      $data2 = Json::encode($products);
//      Log::debug($data2);

      return view('livriz.products_sync.index_ml',compact('products'));
    }
}
