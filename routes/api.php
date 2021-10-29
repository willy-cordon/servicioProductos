<?php

use App\Http\Controllers\AccountServiceOrderController;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => '/v1', 'namespace'=>'api\v1', 'as'=>'api.'], function () {
    Route::get('/users', function (Request $request) { return User::all(); })->middleware('sanctum.abilities:api-users-read');
    Route::get('/services', [ServiceController::class , 'getServices'])->middleware('sanctum.abilities:api-users-read');

    Route::post('/service/{service_id}/product/create-or-update',[ProductController::class, 'serviceProductBulkCreate'])->middleware('sanctum.abilities:api-users-read');
    Route::post('/product/create-or-update',[ProductController::class, 'bulkCreate'])->middleware('sanctum.abilities:api-users-read');

    Route::delete('/service/{service_id}/product/delete', [ProductController::class, 'bulkDeleteByService'])->middleware('sanctum.abilities:api-users-read');
    Route::delete('/product/delete', [ProductController::class, 'bulkDelete'])->middleware('sanctum.abilities:api-users-read');

    Route::get('/service/{service_id}/orders', [AccountServiceOrderController::class, 'ordersByService'])->middleware('sanctum.abilities:api-users-read');
});

Route::group(['prefix' => '/v1', 'namespace'=>'api\v1', 'as'=>'api.'], function () {
    Route::post('/login', [AuthController::class, 'login']);
});

