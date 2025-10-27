<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Lib\Communication;

use App\Models\OrderItem;
use App\Models\User;

class ShopMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:monitor';

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
        $this->cartReminder();
    }

    public function cartReminder(){
        $st = date('Y-m-d H:i:s', strtotime('-24 hour'));
        $nd = date('Y-m-d H:i:s', strtotime('-2 hour'));

        $g_items = OrderItem::whereNull('order_id')->whereBetween('created_at', [$st,$nd])->get()->groupBy('user_id');
        foreach($g_items AS $items){
            $order_data = "<table class='table-bodered' style='width: 100%'>";
            $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>Shopping Cart</th></tr></thead>";
            $usr_id = null;
            foreach($items AS $item){
                $usr_id = $item->user_id;
                $order_data .= "<tr>";
                if($item->product->images->count() > 0){
                    $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$item->product->images->first()->image_url)."'></td>";
                }
                else{
                    $order_data .= "<td></td>";
                }
                $order_data .= "<td>";
                $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
                $order_data .= "<tr><td>Item Name:</td><td>".$item->product->item_name."</td></tr>";
                $order_data .= "<tr><td>Quantity:</td><td>".$item->quantity."</td></tr>";
                $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($item->product->item_price,2)."</td></tr>";
                $order_data .= "</table>";
                $order_data .= "</td>";

                $order_data .= "</tr>";
            }
            $order_data .= "</table>";

            $body = "<b>Looks like you have some unfinished business</b><br /><br />
            You left some items in your cart, and we wanted to remind you they're still available.<br /><br />
            <b>Act fast – items aren't reserved</b><br />
            Your cart doesn't hold items, so someone else could purchase them at any time. Complete your checkout now to secure them before they're gone.<br /><br />
            Ready to finish your order? Just click below to return to your cart.".$order_data;

            $after = "<b>Protected every step of the way</b><br />
            Your payment is held securely in escrow and only released after you confirm delivery. Our buyer protection and transparent transaction history give you complete peace of mind.";

            $user = User::find($usr_id);

            $data = [
                'to' => $user->email,
                'name' => $user->name,
                'subject' => 'Cart reminder',
                'title' => "Your items are waiting – but not for long",
                'message_body' => $body,
                'cta' => true,
                'cta_text' => 'View my cart',
                'cta_url' => url('cart'),
                'after_cta_body' => $after,
            ];
            $comm = new Communication();
            $comm->sendMail($data);
        }
    }
}
