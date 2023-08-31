<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Solditems;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {   
        $sortColumn = $request->input('sort', 'created_at'); 
        $sortDirection = $request->input('direction', 'desc');
        $orders = Order::orderBy($sortColumn, $sortDirection);

        $searchQuery = $request->input('search');

        if ($searchQuery) {
            $orders->where(function ($query) use ($searchQuery) {
                $query->where('invoice_no', 'like', '%' . $searchQuery . '%')
                    ->orWhere('customer_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('customer_email', 'like', '%' . $searchQuery . '%');
            });
        }

        $orders = $orders->paginate(10); 

        return view('order.index', compact('orders', 'sortColumn', 'sortDirection'));
    }



    public function show($order_id)
    {
        $order = Order::with('soldItems')->find($order_id);

        $order->soldItems->map(function ($item) use (&$totalPrice) {
            $product = Product::find($item->product_id);
            $item->product_name = $product->name;
            $item->unit_price = $product->selling_price;
            $item->subtotal = $product->selling_price * $item->quantity;
        });

        return view('order.show', compact( 'order'));
    }

    public function create()
    {   
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

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'payment_method' => 'required|in:credit_card,paypal,Cash',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        $order = new Order();
        
        $order->invoice_no = $this->generateInvoiceNumber();
        
        $order->customer_email = $request->customer_email;
        
        $order->customer_name = $request->customer_name;
        
        $order->payment_method = $request->payment_method;
    
        $productIds = $request->product_ids;
        
        $quantities = $request->quantities;

        $order-> status = 'completed';

        $order->save();

        $totalPrice = 0;

        $profit = 0;
        
        $messages = session('messages', []);

        for ($i = 0; $i < count($productIds); $i++) 
        {
            $solditems = new Solditems();
            
            $solditems->order_id = $order->id;
            
            $solditems->product_id = $productIds[$i];
            
            $solditems->quantity = $quantities[$i];
            
            $product = Product::find($productIds[$i]);
            $product->stock = $product->stock - $quantities[$i];

            if($product->stock < 0)
            {
                $product->stock = $product->stock + $quantities[$i];
                $product->save();
                return redirect()->route('order.create')->with('error', "Product is out of stock");
            }
            
            $totalPrice =  $totalPrice + ($product->selling_price * $quantities[$i]);

            $profit = $profit + (($product->selling_price - $product->purchase_price) * $quantities[$i]);

            $product->save();

            if ($product->stock < 10) {
                $messages[] = $product->name . ' has low stock!';
            }

            $solditems->save();
        }
        
        session()->flash('low_stock', $messages);
        
        $order->amount = $totalPrice;
        $order->p_l = $profit;
        $order->save();
        
        SendEmailJob::dispatch($order->customer_email, $order);
        
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
        
        foreach($order->soldItems as $item)
        {
            $individual_product = Product::find($item->product_id);

            $individual_product->stock = $individual_product->stock + $item->quantity;

            $individual_product->save();
        }

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

        $order->status = $request->status;
         
        $order->save();
        
        $order->touch();

        $order->soldItems()->delete();

        $productIds = $request->product_id;
        
        $quantities = $request->product_quantity;

        $order->amount = 0;

        $totalPrice = 0;

        $profit = 0;

        for ($i = 0; $i < count($productIds); $i++) 
        {   

            $soldItem = new Solditems();
            
            $soldItem->order_id = $order->id;
            
            $soldItem->product_id = $productIds[$i];
            
            $soldItem->quantity = $quantities[$i];
            
            $soldItem->save();

            $product = Product::find($productIds[$i]);
            $product->stock = $product->stock - $quantities[$i];

            if($product->stock < 0)
            {
                $product->stock = $product->stock + $quantities[$i];
                $product->save();
                return redirect()->route('order.create')->with('error', "Product is out of stock");
            }

            $totalPrice =  $totalPrice + ($product->selling_price * $quantities[$i]);

            $profit = $profit + (($product->selling_price - $product->purchase_price) * $quantities[$i]);

            $product->save();
        }

        $order->amount = $totalPrice;
        $order->p_l = $profit;
        $order->save();

        return redirect()->route('order.show', $order_id);
    }



    public function delete($order_id)
    {
        $order = Order::find($order_id);
        $order->delete();
        return redirect()->route('order.index');
    }
    

}
