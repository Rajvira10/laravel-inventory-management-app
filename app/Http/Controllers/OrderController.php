<?php

namespace App\Http\Controllers;

use App\Models\Order;
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


}
