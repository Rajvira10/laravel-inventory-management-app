<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserOrdersExport implements FromCollection
{
    public function collection()
    {
        $user = Auth::guard('web')->user();
        return Order::where('customer_email', $user->email)
                ->orderBy('created_at', 'desc')->get();
    }
}