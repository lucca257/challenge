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
    Route::get('', [OrderController::class,'index'])->name('orders.home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
