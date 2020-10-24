<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('clients')->group(function (){
    Route::get('', [ClientController::class,'home'])->name('clients.home');
});

Route::prefix('products')->group(function (){
    Route::get('', [ProductController::class,'home'])->name('products.home');
});

Route::prefix('orders')->group(function (){
    Route::get('create', [OrderController::class,'create'])->name("orders.create");
    Route::get('{order}', [OrderController::class,'show'])->name('orders.show');
    Route::get('{order}/edit', [OrderController::class,'edit'])->name('orders.edit');
    Route::get('', [OrderController::class,'index'])->name('orders.home');
    Route::post('', [OrderController::class,'store'])->name("orders.store");
    Route::patch('{order}', [OrderController::class,'update'])->name("orders.update");
    Route::delete('{order}', [OrderController::class,'destroy'])->name("orders.destroy");
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
