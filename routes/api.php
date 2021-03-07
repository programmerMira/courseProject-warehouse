<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authLogin'])->name('get_token');

Route::get('/detailCards-list', [App\Http\Controllers\DetailsCardController::class, 'index'])->name('list_detailCards')->middleware(['auth:api','can:readDetailCard']);
Route::get('/detailCards-listByTransport/{transport}', [App\Http\Controllers\DetailsCardController::class, 'getDetailCardsByTransport'])->name('list_detailCardsByTransport')->middleware(['auth:api','can:read']);
Route::get('/detailCardsByCompany-list', [App\Http\Controllers\DetailsCardController::class, 'getDetailCardsByCompany'])->name('list_detailCardsByCompany')->middleware(['auth:api','can:read']);
Route::get('/detailDictionaries-list', [App\Http\Controllers\DetailsDictionaryController::class, 'index'])->name('list_detailDictionaries')->middleware(['auth:api','can:read']);
Route::get('/logs', [App\Http\Controllers\LogController::class, 'index'])->name('list_logs')->middleware(['auth:api','can:create']);
Route::get('/products-list', [App\Http\Controllers\ProductController::class, 'index'])->name('list_products')->middleware(['auth:api','can:readWaybills']);
Route::get('/productsByCompany-list', [App\Http\Controllers\ProductController::class, 'getProductsByCompany'])->name('list_productsByCompany')->middleware(['auth:api','can:read']);
Route::get('/providers', [App\Http\Controllers\ProviderController::class, 'index'])->name('list_providers')->middleware(['auth:api','can:read']);
Route::get('/usersList', [App\Http\Controllers\UserController::class, 'index'])->name('list_users')->middleware(['auth:api','can:create']);
Route::get('/waybills', [App\Http\Controllers\ProductController::class, 'getWaybills'])->name('list_waybills')->middleware(['auth:api','can:read']);
Route::get('/warehouses', [App\Http\Controllers\ProductController::class, 'getWarehouses'])->name('list_warehouses')->middleware(['auth:api','can:readWarehouse']);
Route::get('/contracts', [App\Http\Controllers\ProductController::class, 'contractIndex'])->name('list_contracts')->middleware(['auth:api','can:read']);
Route::get('/companies', [App\Http\Controllers\UserController::class, 'companies'])->name('list_companies')->middleware(['auth:api','can:read']);
Route::get('/transportTypes', [App\Http\Controllers\TransportTypeController::class, 'index'])->name('list_transportTypes')->middleware(['auth:api','can:read']);


Route::get('/transports', [App\Http\Controllers\TransportController::class, 'index'])->name('list_transports')->middleware(['auth:api','can:read']);
Route::get('/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('list_roles')->middleware(['auth:api','can:read']);

