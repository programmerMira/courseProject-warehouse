<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomTestController;
use App\Http\Controllers\HtmlController;




Auth::routes();


Route::post('/authenticate', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);
//ROUTES TO BE DONE
//1)/transportsDelete/id
//2)/transportsCreate
//3)/transportsUpdate/id

/*===============================================================================================================================*/

//views` routes
Route::get('/', [HtmlController::class, 'welcome']);
Route::get('/main', [HtmlController::class, 'main'])->name('incomes')->middleware(['auth', 'can:readWaybills']);
Route::get('/deals', [HtmlController::class, 'deals'])->name('deals')->middleware('auth');
Route::get('/details', [HtmlController::class, 'details'])->name('details')->middleware(['auth', 'can:readWarehouse']);
Route::get('/givers', [HtmlController::class, 'givers'])->name('givers')->middleware('auth');
Route::get('/detail-dict', [HtmlController::class, 'detail_dict'])->name('detail_dict')->middleware('auth');
Route::get('/cards', [HtmlController::class, 'cards'])->name('cards')->middleware(['auth', 'can:readDetailCard']);
Route::get('/transports', [HtmlController::class, 'transport'])->name('transports')->middleware(['auth', 'can:readDetailCard']);
Route::get('/users', [HtmlController::class, 'users'])->name('users')->middleware(['auth', 'can:create']);
Route::get('/history', [HtmlController::class, 'history'])->name('history')->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

/*===============================================================================================================================*/

//gets` routes

/*=================================================================*/

/*===============================================================================================================================*/

//create routes
Route::post('/userCreate', [App\Http\Controllers\UserController::class, 'store'])->name('store_user')->middleware('can:create');
Route::post('/productsCreate', [App\Http\Controllers\ProductController::class, 'store'])->name('create_product')->middleware('can:write');
Route::post('/detailCardCreate', [App\Http\Controllers\DetailsCardController::class, 'store'])->name('create_detailCard')->middleware('can:write');
Route::post('/detailDictionaryCreate', [App\Http\Controllers\DetailsDictionaryController::class, 'store'])->name('create_detailDictionary')->middleware('can:write');
Route::post('/logCreate', [App\Http\Controllers\LogController::class, 'store'])->name('create_log')->middleware('can:write');
Route::post('/providerCreate', [App\Http\Controllers\ProviderController::class, 'store'])->name('create_provider')->middleware('can:write');
Route::post('/transportCreate', [App\Http\Controllers\TransportController::class, 'store'])->name('create_transport')->middleware('can:write');

/*===============================================================================================================================*/

//update routes
Route::put('/userUpdate/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('update_user')->middleware('can:create');
Route::put('/detailDictionaryUpdate/{id}', [App\Http\Controllers\DetailsDictionaryController::class, 'update'])->name('update_detailDictionary')->middleware('can:write');
Route::put('/productsUpdate/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('update_product')->middleware('can:write');
Route::put('/detailCardsUpdate/{id}', [App\Http\Controllers\DetailsCardController::class, 'update'])->name('update_detailCard')->middleware('can:write');
Route::put('/providersUpdate/{id}', [App\Http\Controllers\ProviderController::class, 'update'])->name('update_provider')->middleware('can:write');
Route::put('/transportUpdate/{id}', [App\Http\Controllers\TransportController::class, 'update'])->name('update_transport')->middleware('can:write');


/*===============================================================================================================================*/

//delete routes
Route::delete('/userDelete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('delete_user')->middleware('can:create');
Route::delete('/productsDelete/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy_product')->middleware('can:write');
Route::delete('/providersDelete/{id}', [App\Http\Controllers\ProviderController::class, 'destroy'])->name('destroy_provider')->middleware('can:write');
Route::delete('/detailCardsDelete/{id}', [App\Http\Controllers\DetailsCardController::class, 'destroy'])->name('destroy_detailCard')->middleware('can:write');
Route::delete('/detailDictionaryDelete/{id}', [App\Http\Controllers\DetailsDictionaryController::class, 'destroy'])->name('destroy_detailDictionary')->middleware('can:write');
Route::delete('/transportDelete/{id}', [App\Http\Controllers\TransportController::class, 'destroy'])->name('destroy_transport')->middleware('can:write');


/*===============================================================================================================================*/

//excel-files routes
Route::post('/upload', [App\Http\Controllers\ExcelController::class, 'import'])->name('file_upload');
Route::post('/generate', [App\Http\Controllers\ExcelController::class, 'export'])->name('file_generate');
