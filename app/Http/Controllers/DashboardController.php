<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::guard('admin')->check()) {
                $orders = Order::all();
            } elseif (Auth::guard('web')->check()) {
                $user = Auth::guard('web')->user();
                $orders = Order::where('customer_email', $user->email)->get();            
            }
            return view('dashboard', compact('orders'));
        }

        return view('auth.showlogin'); 
    }

    public function create()
    {
        
        //all products
        $products = Product::all();
        return view('dashboard.create', compact('products'));
    }

    public function store()
    {
        // $data = request()->validate([
        //     'customer_name' => 'required',
        //     'customer_email' => 'required',
        //     'customer_phone' => 'required',
        //     'product_id' => 'required',
        //     'quantity' => 'required',
        //     'amount' => 'required',
        //     'p_l' => 'required',
        // ]);

        // $order = Order::create($data);

        return redirect()->route('dashboard.index');
    }
}
