<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Solditems;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Exports\UserOrdersExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::guard('web')->user();
            $orders = Order::where('customer_email', $user->email)
                ->orderBy('created_at', 'desc') 
                ->paginate(10);
            return view('dashboard', compact('orders'));            
        }
        else if(Auth::guard('admin')->check()){
            $orders = Order::all();
            return view('admin-dashboard', compact('orders')); 
        }
        else{
            return view('auth.login'); 
        }

        
    }

    public function create()
    {
        $products = Product::all();
        return view('dashboard.create', compact('products'));
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
        
        $order->customer_email = auth()->user()->email;
        
        $order->customer_name = auth()->user()->name;
        
        $order->payment_method = $request->payment_method;
    
        $productIds = $request->product_id;
        
        $quantities = $request->product_quantity;



        $order->save();

        $totalPrice = 0;

        $profit = 0;

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
                return redirect()->route('user_order.create')->with('error', "Product is out of stock");
            }
            
            $totalPrice =  $totalPrice + ($product->selling_price * $quantities[$i]);

            $profit = $profit + (($product->selling_price - $product->purchase_price) * $quantities[$i]);

            $product->save();

            $solditems->save();
        }
        
        $order->amount = $totalPrice;
        $order->p_l = $profit;
        $order->save();
        
        SendEmailJob::dispatch($order->customer_email, $order);
        
        return redirect()->route('dashboard.index');
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

        return view('dashboard.show', compact( 'order'));
    }

    public function export(Request $request) 
    {
        $format = $request->format;

        if($format == 'csv')
        {
            return Excel::download(new UserOrdersExport, 'orders.csv');
        }

        return Excel::download(new UserOrdersExport, 'orders.xlsx');
    }
}
