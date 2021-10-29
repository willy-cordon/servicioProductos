<?php

namespace App\Http\Controllers;



use App\Enums\CountryCode;
use App\Enums\CurrencyCode;
use App\Enums\LanguageCode;
use App\Enums\ServiceCode;
use App\Enums\Status;
use App\Http\Requests\Livriz\AccountRequest;
use App\Models\Account;
use App\Models\Service;
use App\Models\User;
use App\Services\AccountService;
use App\Services\MercadoLibre\MLCheckExistingProducts;
use Eastwest\Json\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Collection\Collection;

class AccountController extends Controller
{

    private $accountService;

    public function __construct(AccountService $service)
    {
        $this->accountService = $service;
    }


    public function index()
    {
        $accounts = Account::all();
        $accountServices = $accounts->load('services');
        return view('livriz.accounts.index',compact('accounts','accountServices'));
    }

    public function indexUser()
    {
        $userLogged = User::find(auth()->user()->id);
        return redirect()->route('commons.accounts.user',$userLogged->account_id);
    }


    public function create()
    {

        $servicesAll = Service::all();
        $action =  route("commons.accounts.store");
        $method = 'POST';
        return view('livriz.accounts.create_edit',compact('action','method','servicesAll'));
    }


    public function store(AccountRequest $request)
    {
        $response = $this->accountService->create($request);
        return redirect()->route('commons.accounts.user',$response->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit(Account $account)
    {
        Log::debug($account);
        $servicesAll = Service::all();
        $servicesAvailable = $account->services;
        $services = $account->services->where('service_code',ServiceCode::ML);
        $servicesWoo = $account->services->where('service_code',ServiceCode::WOO);
        $enabledOrderFields = '';
        foreach ($servicesWoo as $serviceWoo)
        {
            if (!empty($serviceWoo->pivot->enabled_order_fields))
            {
                $enabledOrderFields = Json::decode($serviceWoo->pivot->enabled_order_fields, true);
            }
        }

        $status = Status::asSelectArray();
        $countryCodes = CountryCode::asSelectArray();
        $currencyCodes = CurrencyCode::asSelectArray();
        $languageCodes = LanguageCode::asSelectArray();
        $availableOrderFields = Service::availableOrderFields;
        $action = route("commons.accounts.update",[$account->id]);
        $method = 'PUT';
        return view('livriz.accounts.create_edit', compact('account','action','method','services','servicesAvailable','countryCodes','currencyCodes','languageCodes','status','servicesAll','availableOrderFields','enabledOrderFields'));
    }


    public function update(Request $request, Account $account)
    {
        $this->accountService->update($account,$request);
        return redirect()->back();
    }

    public function disconnectMl(Request $request)
    {
         return $this->accountService->disconnectMl($request);
    }


    public function destroy(Account $account)
    {
        $this->accountService->destroy($account);
        return redirect()->route('admin.accounts.index');
    }

    public function restore($id)
    {
        $this->accountService->restore($id);
        return redirect()->route('admin.accounts.index');
    }

}
