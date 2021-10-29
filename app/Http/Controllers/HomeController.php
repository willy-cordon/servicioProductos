<?php

namespace App\Http\Controllers;

use App\Enums\ProductSyncStatus;
use App\Models\Account;
use App\Models\ProductSync;
use App\Models\Service;
use App\Models\User;
use App\Services\HomeService;
use Eastwest\Json\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $homeService;
    public function __construct(HomeService $homeService)
    {
        $this->middleware('auth');
        $this->homeService = $homeService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $userLogged = User::find(auth()->user()->id);
        $account = Account::find($userLogged->account_id);

        $servicesPivot =[];
        $productSyncPending =null;
        $productSyncSynced =null;
        $orders =null;

        if(!empty($account))
        {
            $servicesPivot = $account->services;
            $productSyncPending = $this->homeService->pendingSyncronice($userLogged);
            $productSyncSynced = $this->homeService->productsSynced($userLogged);
            $orders = $this->homeService->ordersForAccount($userLogged,$account);


        }
        if (auth()->user()->hasRole(User::ROLE_CLIENT)){
            return view('home',compact('servicesPivot','productSyncPending','productSyncSynced','orders'));

        }elseif (auth()->user()->hasRole(User::ROLE_ADMIN)){

            $countUsers= User::all()->count();
            $countServices = Service::all()->count();
            $countAccounts = Account::all()->count();
            $countProductsSync = $this->homeService->countProductsSyncAdmin();
            $users = User::latest()->get();

            return view('home_admin', compact('users','countUsers','countServices','countAccounts','countProductsSync'));
        }


    }

    public function index2()
    {
        return view('sample');
    }
}
