<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
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

Route::group(['prefix' => 'clients'], function() {
    Route::get('', [ClientController::class,'list'])->name('api.clients.list');
    Route::post('', [ClientController::class,'store'])->name("api.clients.store");
    Route::get('find/{client?}', [ClientController::class,'find'])->name("api.clients.store");
    Route::patch('{client}', [ClientController::class,'update'])->name("api.clients.update");
    Route::delete('{client}', [ClientController::class,'destroy'])->name("api.clients.destroy");
});

Route::group(['prefix' => 'products'], function() {
    Route::get('', [ProductController::class,'index'])->name('products.index');
    Route::post('', [ProductController::class,'store'])->name("products.store");
    Route::post('find/{product?}', [ProductController::class,'find'])->name("products.find");
    Route::delete('{product}', [ProductController::class,'destroy'])->name("products.destroy");
    Route::patch('{product}', [ProductController::class,'update'])->name("products.update");
});

Route::group(['prefix' => 'orders'], function() {
    //Route::get('', [OrderController::class,'index'])->name('api.orders.index');
    Route::post('', [OrderController::class,'store'])->name('api.orders.store');
    Route::patch('{order}', [OrderController::class,'update'])->name("api.orders.update");
    Route::delete('{order}', [OrderController::class,'destroy'])->name("api.orders.destroy");
});
