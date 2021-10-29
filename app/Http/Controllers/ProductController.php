<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\MlSyncService;
use App\Services\ProductService;
use Eastwest\Json\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @Group(name="Productos", description="Endpoints Livriz Market")
 */
class ProductController extends Controller
{
    private $productService;
    private $mlSyncService;
    public function __construct(ProductService $productService, MlSyncService $mlSyncService)
    {
        $this->productService = $productService;
        $this->mlSyncService = $mlSyncService;
    }

    /**
     * @Endpoint(name="service/{service_id}/product/create-or-update", description="Crear o actualizar producto para un determiando servicio")
     * @BodyParam(name = "service_id", type = "number", status = "required", description = "Create or update product and service by service Id", example = "1")
     * @ResponseExample(status=200, file="responses/productServiceSingle.json")
     */
    public function productServiceSingle(Request $request)
    {
        $serviceId = $request->route('service_id');
        return Json::encode($this->productService->create($request,$serviceId));
    }

    /**
     * @Endpoint(name="/product/create-or-update", description="Crear o actualizar producto")
     * @BodyParam(name = "product_code", type = "json", status = "required", description = "Product_code = ISBN ", example = "1")
     * @BodyParam(name = "catalog_code", type = "json", status = "required", description = "Product_code = ISBN ", example = "1")
     * @ResponseExample(status=200, file="responses/bulk.json")
     *
     */
    public function productServiceAll(Request $request)
    {
        return Json::encode($this->productService->create($request));
    }

    /**
     * @Endpoint(name="product/create-or-update/bulk", description="Crear o actualizar productos masivamente")
     * @BodyParam(name = "product_code", type = "json", status = "required", description = "Product_code = ISBN ", example = "1")
     * @BodyParam(name = "catalog_code", type = "json", status = "required", description = "Product_code = ISBN ", example = "1")
     * @ResponseExample(status=200, file="responses/bulk.json")
     *
     */
    public function bulkCreate(Request $request)
    {
        return Json::encode($this->productService->bulkCreateProduct($request));
    }

    /**
     * @Endpoint(name="/service/{service_id}/product/create-or-update/bulk", description="Crear o actualizar productos masivamente segun el servicio")
     * @BodyParam(name = "product_code", type = "json", status = "required", description = "Product_code = ISBN ", example = "1")
     * @BodyParam(name = "catalog_code", type = "json", status = "required", description = "Product_code = ISBN ", example = "1")
     * @ResponseExample(status=200, file="responses/bulk.json")
     *
     */
    public function serviceProductBulkCreate(Request $request)
    {
        $serviceId = $request->route('service_id');
        return Json::encode($this->productService->bulkCreateProduct($request,$serviceId));
    }



    /**
     * @Endpoint(name="product/delete", description="Borrar producto.")
     * @ResponseExample(status=200, file="responses/deleteProduct.json")
     */
    public function deleteProduct(Request $request)
    {
        return Json::encode($this->productService->delete($request));
    }
    /**
     * @Endpoint(name="service/{service_id}/product/delete", description="Borrar producto de un determiado servicio.")
     * @BodyParam(name = "service_id", type = "number", status = "required", description = "Delete product by service id", example = "service/3/product/delete")
     * @ResponseExample(status=200, file="responses/deleteProductByServiceId.json")
     */
    public function deleteProductByServiceId(Request $request)
    {
        $serviceId = $request->route('service_id');
        return Json::encode($this->productService->delete($request,$serviceId));
    }

    /**
     * @Endpoint(name="/product/delete/bulk", description="Borrar productos masivamente.")
     * @BodyParam(name = "service_id", type = "number", status = "required", description = "Delete product by service id", example = "service/3/product/delete")
     * @ResponseExample(status=200, file="responses/deleteProductByServiceId.json")
     */
    public function bulkDelete(Request $request)
    {
        return Json::encode($this->productService->bulkDeleteProduct($request));
    }

    /**
     * @Endpoint(name="/service/{service_id}/product/delete/bulk", description="Borrar productos segun el servicio.")
     * @BodyParam(name = "service_id", type = "number", status = "required", description = "Delete product by service id", example = "service/3/product/delete")
     * @ResponseExample(status=200, file="responses/deleteProductByServiceId.json")
     */
    public function bulkDeleteByService(Request $request)
    {
        $serviceId = $request->route('service_id');
        return Json::encode($this->productService->bulkDeleteProduct($request,$serviceId));
    }

    public function forAccount()
    {
        $accountId = auth()->user()->account_id;

        return view('livriz.products.index', compact('accountId'));
    }

    public function dataTables(Request $request)
    {
        return $this->productService->getDatatables($request);
    }

    public function manualSynchronizeProducts(Request $request)
    {

        return $this->mlSyncService->syncroniceProducts($request->get('id'));
    }

}
