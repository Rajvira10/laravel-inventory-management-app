<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Solditems;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //show all orders
    public function index()
    {
        return view('orders.index',[
            'orders' => Order::all(),
        ]);
    }

    //show single order
    public function show($id)
    {
        $order = Order::with('soldItems')->find($id);
        //find the name of the product
        $order->soldItems->map(function ($item) {
            $item->product_name = Product::find($item->product_id)->name;
            return $item;
        });
    
        return view('orders.show', ['order' => $order]);
    }

    //create new order
    public function create()
    {   
        //return all products
        $products = Product::all();

        return view('orders.create',['products' => $products]);
    }

    public function generateInvoiceNumber($length = 8)
    {
        $characters = '0123456789';
        $invoiceNumber = '';

        for ($i = 0; $i < $length; $i++) {
            $invoiceNumber .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $invoiceNumber;
    }
  

    //store new order
    public function store()
    {
        $order = new Order();
        $order->invoice_no = $this->generateInvoiceNumber();
        $order->customer_email = request('customer_email');
        $order->customer_name = request('customer_name');
        $order->payment_method = request('payment_method');
        $order->save();

        $productIds = request('product_ids');
        $quantities = request('quantities');

        for ($i = 0; $i < count($productIds); $i++) {
            $solditems = new Solditems();
            $solditems->order_id = $order->id;
            $solditems->product_id = $productIds[$i];
            $solditems->quantity = $quantities[$i];
            $solditems->save();
        }

        return redirect()->route('orders.index');
    }


    //edit order
    public function edit($id)
    {
        $products = Product::all();
        $order = Order::with('soldItems')->find($id);
        $order->soldItems->map(function ($item) {
            $item->product_name = Product::find($item->product_id)->name;
            return $item;
        });
    
        return view('orders.edit',[
            'order' => Order::find($id),
            'allproducts' => $products,
        ]);
    }

    //update order
public function update($id)
{
    $order = Order::find($id);
    $order->customer_email = request('customer_email');
    $order->customer_name = request('customer_name');
    $order->payment_method = request('payment_method');
    $order->save();

    $productIds = request('product_id');
    $quantities = request('product_quantity');
    $index = 0;
    foreach ($order->soldItems as $soldItem) {
        $soldItem->product_id = $productIds[$index];
        $soldItem->quantity = $quantities[$index];
        $soldItem->save();
        $index++;
    }

    return redirect()->route('orders.index');
}


    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('orders.index');
    }
    

}
