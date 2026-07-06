<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Order;

use App\Lib\WalletDocApi;

class TrackTranactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:track-tranactions';

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
        $this->init();
    }

    public function init(){
        $orders = Order::whereNotNull('uuid')->whereNull('status')->get();
        foreach($orders AS $order){
            $doc = new WalletDocApi();
            $res = $doc->checkPayment($order->uuid);
            dd($res);
        }
    }
}
