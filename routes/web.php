<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Solditems;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
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

//homepage
Route::get('/', function () {
    $total_sales = Order::sum('amount');

    $total_gross_profit = Order::sum('p_l');

    $total_orders = Order::count();

    $total_products_sold = Solditems::sum('quantity');

    $products_in_stock = Product::sum('stock');

    $number_of_products = Product::count();

    return view('welcome', compact('total_sales','total_gross_profit', 'total_orders', 'total_products_sold', 'products_in_stock', 'number_of_products'));
})->name('home');


Route::group(['prefix' => 'product'], function() {
    Route::get('export', [ProductController::class, 'export'])->name('product.export');
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
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


Route::get('/report', [ReportController::class, 'index'])->name('report.index');
