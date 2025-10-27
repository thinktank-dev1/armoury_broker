<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Lib\Communication;

use App\Models\user;
use App\Models\Order;

class ShippingMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipping:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send shipping update reminder emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->init();
    }

    public function init(){
        $orders = Order::where('status', 'COMPLETE')->where('updated_at', '<=', Carbon::now()->subHours(48))->where('shipping_status',0)->where('receipt_status',0)->get();
        foreach($orders AS $order){
            $order_data = "<table class='table-bodered' style='width: 100%'>";
            $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</th></tr></thead>";
            $order_data .= "<tbody>";
            foreach($order->items AS $item){
                if(!$item->vendor_status && !$item->buyer_status){
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

            $body = "Some of your sold items still needs a shipment confirmation update.<br /><br />
            Once you have shipped the item, remember to update the delivery status in the order to \"Order Dispatched\" or in the case of a firearm transaction, \"Dealer Stocked\".<br /><br />
            If you need assistance, please view our FAQs or email support@armourybroker.com for assistance.".$order_data;

            $after = "As a reminder, funds will only be released to you once the buyer has confirmed receipt or dealer stocking of the items.";

            $user = $order->vendor->user;

            $data = [
                'to' => $user->email,
                'name' => $user->name,
                'subject' => 'Action required: Update shipping status',
                'title' => "Action required: Update shipping status",
                'message_body' => $body,
                'cta' => true,
                'cta_text' => 'View Order',
                'cta_url' => url('my-orders'),
                'after_cta_body' => $after,
            ];
            $comm = new Communication();
            $comm->sendMail($data);
        }
    }
}
