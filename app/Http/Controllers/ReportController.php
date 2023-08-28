<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;


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

        $profitLossData = [
            'dates' => [],
            'values' => [],
        ];

        $dailyTotals = [];

        foreach ($orders as $order) {
            $date = $order->created_at->format('Y-m-d');
            
            if (!isset($dailyTotals[$date])) {
                $dailyTotals[$date] = 0;
            }
            
            $dailyTotals[$date] += $order->p_l;
        }

        foreach ($dailyTotals as $date => $total) {
            $profitLossData['dates'][] = $date;
            $profitLossData['values'][] = $total;
        }

        $ordersPerDayData = [
            'dates' => [],
            'values' => [],
        ];

        foreach ($dailyTotals as $date => $total) {
            $ordersPerDayData['dates'][] = $date;
            $ordersPerDayData['values'][] = $total; 
        }

        return view('report.index', compact('orders', 'sortColumn', 'sortDirection','profitLossData', 'ordersPerDayData'));
    }
}
