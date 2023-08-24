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

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');  
Route::get('/products/{id}', [ProductController::class, 'show']); 
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); 
Route::put('/products/{id}', [ProductController::class, 'update']) ->name('products.update'); 
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); 
Route::get('/', [ProductController::class, 'index'])->name('products.index');



//Orders

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])-> name('orders.create');
Route::get('/orders/{id}', [OrderController::class, 'show'])-> name('orders.show');
Route::post('/orders', [OrderController::class, 'store']) -> name('orders.store');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])-> name('orders.edit');
Route::put('/orders/{id}', [OrderController::class, 'update'])-> name('orders.update');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])-> name('orders.destroy');

