<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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


Route::get('/', [ProductController::class, 'index'])->name('product.index');

Route::group(['prefix' => 'product'], function() {
    
    Route::get('create', [ProductController::class, 'create'])->name('product.create'); 
    Route::post('store', [ProductController::class, 'store'])->name('product.store'); 
    Route::get('/{product_id}', [ProductController::class, 'show'])->name('product.show'); 
    Route::get('edit/{product_id}', [ProductController::class, 'edit'])->name('product.edit'); 
    Route::post('update/{product_id}', [ProductController::class, 'update']) ->name('product.update'); 
    Route::delete('/{product_id}', [ProductController::class, 'delete'])->name('product.delete'); 

});


//Orders

Route::group(['prefix' => 'order'], function() {

    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::get('/create', [OrderController::class, 'create'])-> name('order.create');
    Route::post('store', [OrderController::class, 'store']) -> name('order.store');
    Route::get('/{order_id}', [OrderController::class, 'show'])-> name('order.show');
    Route::get('edit/{order_id}', [OrderController::class, 'edit'])-> name('order.edit');
    Route::put('update/{order_id}', [OrderController::class, 'update'])-> name('order.update');
    Route::delete('/{order_id}', [OrderController::class, 'delete'])-> name('order.delete');

});

