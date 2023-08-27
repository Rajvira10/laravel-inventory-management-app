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

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])-> name('orders.create');
Route::get('/orders/{id}', [OrderController::class, 'show'])-> name('orders.show');
Route::post('/orders', [OrderController::class, 'store']) -> name('orders.store');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])-> name('orders.edit');
Route::put('/orders/{id}', [OrderController::class, 'update'])-> name('orders.update');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])-> name('orders.destroy');

