<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Mail\RemindOrderPayment;
use App\Models\Order; // Import the Order model
use Mail;

class RemindEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sendMail;
    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sendMail, Order $order) // Specify the type of $order
    {
        $this->sendMail = $sendMail;
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new RemindOrderPayment($this->order);
        Mail::to($this->sendMail)->send($email);
    }
}

