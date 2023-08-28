<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->input('sort', 'created_at'); 
        $sortDirection = $request->input('direction', 'desc');
        $orders = Order::orderBy($sortColumn, $sortDirection);

        $searchQuery = $request->input('search');

        if ($searchQuery) {
            $orders->where(function ($query) use ($searchQuery) {
                $query->where('invoice_no', 'like', '%' . $searchQuery . '%');
            });
        }

        $orders = $orders->paginate(10); 

        return view('report.index', compact('orders', 'sortColumn', 'sortDirection'));
    }
}
