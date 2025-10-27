<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Lib\Communication;

use App\Models\user;
use App\Models\Order;

class ReceiptMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receipt:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send receipt update reminder emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->init();
    }

    public function init(){
        $orders = Order::query()
        ->where('status', 'COMPLETE')
        ->where('updated_at', '<=', Carbon::now()->subHours(72))
        ->whereHas('items', function($q){
            return $q->where('vendor_status', 'Order Dispatched')->whereNull('buyer_status');
        })
        ->get();

        foreach($orders AS $order){
            $order_data = "<table class='table-bodered' style='width: 100%'>";
            $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</th></tr></thead>";
            $order_data .= "<tbody>";
            foreach($order->items AS $item){
                if($item->vendor_status && !$item->buyer_status){
                    $order_data .= "<tr>";
                    if($item->product->images->count() > 0){
                        $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$item->product->images->first()->image_url)."'></td>";
                    }
                    else{
                        $order_data .= "<td></td>";
                    }
                    $order_data .= "<td>";
                    $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
                    $order_data .= "<tr><td>Order Date:</td><td>".date('Y-m-d', strtotime($item->created_at))."</td></tr>";
                    $order_data .= "<tr><td>Item Name:</td><td>".$item->product->item_name."</td></tr>";
                    $order_data .= "<tr><td>Quantity:</td><td>".$item->quantity."</td></tr>";
                    $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($item->product->item_price,2)."</td></tr>";
                    $order_data .= "<tr><td>Sold Price:</td><td>R ".number_format($item->price,2)."</td></tr>";
                    $order_data .= "<tr><td>Discount Applied:</td><td>".$item->discount."</td></tr>";
                    $order_data .= "<tr><td>Delivery Type:</td><td>".$item->shipping_method."</td></tr>";
                    $order_data .= "</table>";
                    $order_data .= "</td>";
                    $order_data .= "</tr>";
                }
            }
            $order_data .= "<tr><td><b>Total Paid</b></td><td><b>R ".number_format(($order->cart_total + $order->total_shipping_fee),2)."</b></td></tr>";
            $order_data .= "</table>";

            $body = "Some of your purchased items still needs a delivery confirmation.<br />".$order_data;

            $after = "<b>Next step:</b><br />
            Once you've received the item, update the order status to:<br />
            <ul>
                <li>\"Order Received\" for general items</li>
                <li>\"Dealer Stocked\" for firearms</li>
            </ul><br />
            This allows us to release payment to the seller and close the transaction.<br /><br />
            Need help? Check our FAQs or contact us at support@armourybroker.com";

            $user = $order->user;

            $data = [
                'to' => $user->email,
                'name' => $user->name,
                'subject' => 'Action needed: Confirm delivery',
                'title' => "Action needed: Confirm delivery",
                'message_body' => $body,
                'cta' => true,
                'cta_text' => 'View Purchase',
                'cta_url' => url('my-purchases'),
                'after_cta_body' => $after,
            ];
            $comm = new Communication();
            $comm->sendMail($data);
        }
    }
}
