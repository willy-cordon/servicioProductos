<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\WooStatus;
use App\Models\AccountServiceOrder;
use App\Services\AccountServiceOrderService;
use App\Services\MLAccountServiceOrder;
use App\Services\WooAccountServiceOrder;
use Eastwest\Json\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @Group(name="Ordenes", description="Ordenes por servicio de cuenta")
 */
class AccountServiceOrderController extends Controller
{


    /**
     * AccountServiceOrderController constructor.
     */
    private $accountServiceOrderService;
    private $wooAccountServiceOrder;
    private $mlAccountServiceOrder;
    public function __construct(AccountServiceOrderService $accountServiceOrderService, WooAccountServiceOrder $wooAccountServiceOrder,MLAccountServiceOrder $mlAccountServiceOrder)
    {
        $this->accountServiceOrderService = $accountServiceOrderService;
        $this->wooAccountServiceOrder = $wooAccountServiceOrder;
        $this->mlAccountServiceOrder = $mlAccountServiceOrder;
    }

    public function index($id)
    {

        $accountServiceCode = DB::table('account_service')
            ->leftJoin('services','services.id','=','account_service.service_id')
            ->where('account_service.id',$id)
            ->select(['services.service_code'])
            ->first();
        $accountServiceId = $id;
        $accountServiceOrderQuery = AccountServiceOrder::query();
        $accountServiceOrderQuery->where('account_service_id',$id);
        $accountServiceOrders = $accountServiceOrderQuery->get();

//        Log::debug($accountServiceOrders);
        return view('livriz.orders.index', compact('accountServiceOrders','accountServiceCode','accountServiceId'));
    }

    public function indexWoo($id)
    {
        $accountServiceOrderQuery = AccountServiceOrder::query();
        $accountServiceOrderQuery->where('account_service_id',$id);
        $accountServiceOrders = $accountServiceOrderQuery->get();
        $accountServiceId = $id;
        $statusWoo = WooStatus::asSelectArray();

        $accountServiceTable = DB::table('account_service')
            ->where('id',$id)
            ->first();
        $enabledOrderFields = !empty($accountServiceTable->enabled_order_fields) ? Json::decode($accountServiceTable->enabled_order_fields, true):[];


        return view('livriz.orders.index_woo', compact('accountServiceOrders','accountServiceId','statusWoo','enabledOrderFields'));
    }

    public function datatablesWoo(Request $request)
    {
        return $this->accountServiceOrderService->getDatatables($request);
    }

    public function manualSynchronizeOrderWoo(Request $request)
    {
        return $this->wooAccountServiceOrder->synchronizeOrdersWoo($request->get('id'));
    }
    public function manualSynchronizeOrderML(Request $request)
    {
        return $this->mlAccountServiceOrder->getServiceML($request->get('id'));
    }

     /**
     * @Endpoint(name="/service/{service_id}/orders", description="Consultar los servicios que tiene asociados la cuenta del usuario")
     * @ResponseExample(status=200, file="responses/getServices.json")
     */
    public function ordersByService(Request $request)
    {
        $serviceId = $request->route('service_id');
        return Json::encode($this->accountServiceOrderService->ordersByService($serviceId));
    }
}
