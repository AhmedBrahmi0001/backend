<?php

namespace App\Console\Commands;

use App\Jobs\SendOrderPositionJob;
use App\Models\Order;
use Illuminate\Console\Command;

class SendOrderPosition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-order-position';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('etat','ongoing')->get();
        foreach($orders as $order){
            SendOrderPositionJob::dispatch($order);
        }
    }
}
