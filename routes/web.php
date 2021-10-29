<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountServiceOrderController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MLGatewayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSyncController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard/home');

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth', 'users_manage.permission'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('roles', RolesController::class);
    Route::delete('roles_mass_destroy', [RolesController::class, 'massDestroy'])->name('roles.mass_destroy');
    Route::resource('users', UsersController::class);
    Route::delete('users_mass_destroy', [UsersController::class, 'massDestroy'])->name('users.mass_destroy');

    Route::get('account-services', [ServiceController::class, 'accountServiceAll'])->name('account_services.indexAll');
    Route::get('account-services/{id}', [ServiceController::class, 'AccountServiceByUser'])->name('account-services.AccountServiceByUser');

    Route::resource('accounts',AccountController::class)->except('edit','create','update');
    Route::patch('accounts/{account_id}/restore',[AccountController::class,'restore'])->name('accounts.restore');

    Route::resource('services', ServiceController::class);
    Route::patch('services/{service_id}/restore',[ServiceController::class,'restore'])->name('services.restore');

});

Route::group(['middleware' => ['auth'], 'prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('change_password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change_password');
    Route::patch('change_password', [ChangePasswordController::class, 'changePassword'])->name('change_password_update');
});

Route::group(['middleware' => ['auth', 'commons.permission'], 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/sample', [HomeController::class, 'index2'])->name('sample');
});

Route::group(['middleware' => ['auth', 'commons.permission'], 'prefix' => 'commons', 'as' => 'commons.'], function () {
    Route::post('accounts/disconnectMl',[AccountController::class, 'disconnectMl'])->name('accounts.disconnectMl');
    Route::get('accounts/create',[AccountController::class, 'create'])->name('accounts.create');
    Route::post('accounts/store',[AccountController::class, 'store'])->name('accounts.store');

    Route::get('accounts/{account}/edit',[AccountController::class, 'edit'])->name('accounts.user')->middleware('check.account');
    Route::put('accounts/update/{account}',[AccountController::class, 'update'])->name('accounts.update')->middleware('check.account');
    Route::get('services/service_account',[ServiceController::class, 'serviceAccount'])->name('services.serviceAccount')->middleware('check.account.service');


    Route::get('account_service_order/ml/{id}',[AccountServiceOrderController::class, 'index'])->name('accountServiceOrder.index');
    Route::get('account_service_order/datatables/ml',[AccountServiceOrderController::class, 'datatablesML'])->name('accountServiceOrder.datatables.ml');

    Route::get('account_service_order/woo/{id}',[AccountServiceOrderController::class, 'indexWoo'])->name('accountServiceOrder.indexWoo');
    Route::get('account_service_order/datatables/woo',[AccountServiceOrderController::class, 'datatablesWoo'])->name('accountServiceOrder.datatables.woo');

    Route::get('products/ml/dashboard/{id}',[ProductSyncController::class, 'indexML'])->name('products.dashboard.indexML');

    Route::get('products/account/user',[ProductController::class, 'forAccount'])->name('products.account')->middleware('check.account');
    Route::get('products/datatables',[ProductController::class, 'dataTables'])->name('products.datatables');

    Route::get('synchronize_orders/WOO', [AccountServiceOrderController::class, 'manualSynchronizeOrderWoo'])->name('synchronize.orders.woo');
    Route::get('synchronize_orders/ML', [AccountServiceOrderController::class, 'manualSynchronizeOrderML'])->name('synchronize.orders.ml');
    Route::get('synchronize_products', [ProductController::class, 'manualSynchronizeProducts'])->name('synchronize.products');
});



Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/ml-gateway',[MLGatewayController::class, 'callbackHandler'])->name('ml-gateway');



