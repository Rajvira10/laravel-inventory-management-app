<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Order;
use App\Jobs\RemindEmailJob;
use Illuminate\Console\Command;

class SendPendingOrderReminders extends Command
{
    protected $signature = 'orders:send-reminders';
    protected $description = 'Send reminders for pending orders older than 5 days';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pendingOrders = Order::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subDays(5))
            ->get();

        foreach ($pendingOrders as $order) {
            RemindEmailJob::dispatch($order->customer_email, $order);
        }

        $this->info('Pending order reminders sent successfully.');
    }
}
