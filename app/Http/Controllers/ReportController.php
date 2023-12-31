<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ReportController extends Controller
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
                $query->where('invoice_no', 'like', '%' . $searchQuery . '%');
            });
        }

        $paginatedorders = $orders->paginate(10); 
        //get orders of last 7 days
        $orders = Order::where('created_at', '>=', Carbon::now()->subDays(7))->get();

        $profitLossData = [
            'dates' => [],
            'values' => [],
        ];

        $orderCountData = [
            'dates' => [],
            'values' => [],
        ];

        $dailyTotals = [];
        $dailyOrderCounts = [];

        foreach ($orders as $order) {
            $date = $order->created_at->format('Y-m-d');
            
            if (!isset($dailyTotals[$date])) {
                $dailyTotals[$date] = 0;
                $dailyOrderCounts[$date] = 0;
            }
            
            $dailyTotals[$date] += $order->p_l;
            $dailyOrderCounts[$date]++;
        }

        foreach ($dailyTotals as $date => $total) {
            $profitLossData['dates'][] = $date;
            $profitLossData['values'][] = $total;
        }

        foreach ($dailyOrderCounts as $date => $count) {
            $orderCountData['dates'][] = $date;
            $orderCountData['values'][] = $count;
        }

        return view('report.index', compact('paginatedorders', 'sortColumn', 'sortDirection', 'profitLossData', 'orderCountData'));
    }
}
