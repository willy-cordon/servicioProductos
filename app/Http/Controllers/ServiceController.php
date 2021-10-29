<?php

namespace App\Http\Controllers;

use App\Enums\CountryCode;
use App\Enums\CurrencyCode;
use App\Enums\LanguageCode;
use App\Enums\ServiceCode;
use App\Http\Requests\Livriz\ServiceRequest;
use App\Models\Account;
use App\Models\Service;
use App\Models\User;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @Group(name="Servicios", description="Servicios de una cuenta")
 */
class ServiceController extends Controller
{
    private $serviceService;
    public function __construct(ServiceService $service)
    {
        $this->serviceService = $service;
    }

    public function index()
    {
        $services = $this->serviceService->all();
        return view('livriz.services.index', compact('services'));
    }

    public function serviceAccount()
    {
        $userLogged = User::find(auth()->user()->id);
        $account = Account::find($userLogged->account_id);
        $servicesPivot = $account->services;

        return view('livriz.services.index_service_user', compact('servicesPivot'));

    }

    public function accountServiceAll()
    {
        $accounts = Account::all();

        return view('livriz.services.index_account_service', compact('accounts'));
    }

    public function AccountServiceByUser($id)
    {
        $account = Account::find($id);
        $servicesPivot = $account->services;
        return view('livriz.services.index_service_user', compact('servicesPivot'));
    }

    public function create()
    {
        $action =  route("admin.services.store");
        $countryCodes = CountryCode::asSelectArray();
        $currencyCodes = CurrencyCode::asSelectArray();
        $languageCodes = LanguageCode::asSelectArray();
        $serviceCodes = ServiceCode::asSelectArray();
        $method = 'POST';
        return view('livriz.services.create_edit',compact('action','method','countryCodes','currencyCodes', 'languageCodes','serviceCodes'));
    }


    public function store(ServiceRequest $request)
    {
        $this->serviceService->create($request);
        return redirect()->route('admin.services.index');
    }


    public function edit(Service $service)
    {

        $countryCodes = CountryCode::asSelectArray();
        $currencyCodes = CurrencyCode::asSelectArray();
        $languageCodes = LanguageCode::asSelectArray();
        $serviceCodes = ServiceCode::asSelectArray();
        $action = route("admin.services.update",[$service->id]);
        $method = 'PUT';
        return view('livriz.services.create_edit', compact('service','action','method','countryCodes','currencyCodes', 'languageCodes','serviceCodes'));
    }


    public function update(Request $request, Service $service)
    {
        $this->serviceService->update($service,$request);
        return redirect()->route('admin.services.index');
    }


    public function destroy(Service $service)
    {
        $this->serviceService->destroy($service);
        return redirect()->route('admin.services.index');
    }

    public function restore($id)
    {
        $this->serviceService->restore($id);
        return redirect()->route('admin.services.index');
    }

    /**
     * @Endpoint(name="services", description="Consultar los servicios que tiene asociados la cuenta del usuario")
     * @ResponseExample(status=200, file="responses/getServices.json")
     */
    public function getServices()
    {
        return $this->serviceService->getServicesForAccount();
    }
}
