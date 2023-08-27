<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Solditems;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::all();
        return view('order.index', compact('orders'));
    }

    public function show($order_id)
    {
        $order = Order::with('soldItems')->find($order_id);

        $order->soldItems->map(function ($item) {
            $item->product_name = Product::find($item->product_id)->name;
            $item->product_price = Product::find($item->product_id)->selling_price * $item->quantity;
            return $item;
        });
        
        $totalPrice = 0;
        foreach ($order->soldItems as $item) {
            $totalPrice += $item->quantity * Product::find($item->product_id)->selling_price;
        }

        return view('order.show', compact('totalPrice', 'order'));
    }

    public function create()
    {   
        //show products that are not out of stock
        $products = Product::where('stock', '>', 0)->get();

        return view('order.create', compact('products'));
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
  
    public function store(Request $request)
    {
        $order = new Order();
        
        $order->invoice_no = $this->generateInvoiceNumber();
        
        $order->customer_email = $request->customer_email;
        
        $order->customer_name = $request->customer_name;
        
        $order->payment_method = $request->payment_method;
        


        $productIds = $request->product_ids;
        
        $quantities = $request->quantities;

        for ($i = 0; $i < count($productIds); $i++) 
        {
            $solditems = new Solditems();
            
            $solditems->order_id = $order->id;
            
            $solditems->product_id = $productIds[$i];
            
            $solditems->quantity = $quantities[$i];
            
            //remove items from product stock
            $product = Product::find($productIds[$i]);
            $product->stock = $product->stock - $quantities[$i];

            if($product->stock < 0)
            {
                $product->stock = $product->stock + $quantities[$i];
                $product->save();
                return redirect()->route('order.create')->with('error', "Product is out of stock");
            }

            $product->save();

            $solditems->save();
        }

        $order->save();

        return redirect()->route('order.index');
    }

    public function edit($order_id)
    {
        $product = Product::all();
        $order = Order::with('soldItems')->find($order_id);
        $order->soldItems->map(function ($item) {
            $item->product_name = Product::find($item->product_id)->name;
            return $item;
        });
        
        return view('order.edit',[
            'order' => $order,
            'allproducts' => $product,
        ]);
    }


    public function update(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        
        $order->customer_email = $request->customer_email;
        
        $order->customer_name = $request->customer_name;
        
        $order->payment_method = $request->payment_method;
        
        $order->save();
        
        $order->touch();

        $order->soldItems()->delete();

        $productIds = $request->product_id;
        
        $quantities = $request->product_quantity;



        for ($i = 0; $i < count($productIds); $i++) 
        {   

            $soldItem = new Solditems();
            
            $soldItem->order_id = $order->id;
            
            $soldItem->product_id = $productIds[$i];
            
            $soldItem->quantity = $quantities[$i];
            
            $soldItem->save();
        }

        return redirect()->route('order.show', $order_id);
    }



    public function delete($order_id)
    {
        $order = Order::find($order_id);
        $order->delete();
        return redirect()->route('order.index');
    }
    

}
