<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('clients')->group(function (){
    Route::get('', [ClientController::class,'index'])->name('clients.index');
    Route::get('create', [ClientController::class,'create'])->name("clients.create");
    Route::get('{client}', [ClientController::class,'show'])->name('clients.show');
    Route::get('{client}/edit', [ClientController::class,'edit'])->name('clients.edit');
});

Route::prefix('products')->group(function (){
    Route::get('', [ProductController::class,'index'])->name('products.index');
    Route::get('create', [ProductController::class,'create'])->name("products.create");
    Route::get('{product}', [ProductController::class,'show'])->name('products.show');
    Route::get('{product}/edit', [ProductController::class,'edit'])->name('products.edit');
});

Route::prefix('orders')->group(function (){
    Route::get('create', [OrderController::class,'create'])->name("orders.create");
    Route::get('{order}', [OrderController::class,'show'])->name('orders.show');
    Route::get('{order}/edit', [OrderController::class,'edit'])->name('orders.edit');
    Route::get('', [OrderController::class,'index'])->name('orders.index');
    Route::post('', [OrderController::class,'store'])->name("orders.store");
    Route::patch('{order}', [OrderController::class,'update'])->name("orders.update");
    Route::delete('{order}', [OrderController::class,'destroy'])->name("orders.destroy");
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
