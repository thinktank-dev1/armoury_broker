<?php

namespace App\Http\Controllers;

use Request;

use App\Lib\Communication;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\PromoCode;
use App\Models\WithdrawalRequest;
use App\Models\User;
use App\Models\Vendor;

class ProcessPayment extends Controller
{
    public function pfPayment($id){
        $order = Order::find($id);
        if($order){
            $order->g_payment_id = Request::input('pf_payment_id');
            $order->amount_paid = Request::input('amount_gross');
            $order->status = Request::input('payment_status');
            $order->save();

            if(strtolower(Request::input('payment_status')) == "complete"){
                $tot = Request::input('amount_gross');
                foreach($order->items AS $item){
                    $amount = $item->price * $item->quantity;
                    $amount += $item->shipping_fee;
                    $amount += $item->service_fee;
                    Transaction::create([
                        'transaction_type' => 'payfast_payment',
                        'user_id' => $order->user_id,
                        'vendor_id' => $item->vendor_id,
                        'direction' => 'in',
                        'amount' => $amount,
                        'order_id' => $order->id,
                        'order_item_id' => $item->id,
                        'payment_status' => Request::input('payment_status'),
                    ]);
                }

                $comm = new Communication();
                
                $user = User::find($order->user_id);
                if($user){
                    $data = [
                        'name' => $user->name,
                        'to' => $user->email,
                        'subject' => 'Armoury Broker Payment Received',
                        'message_body' => "
                            Your payment for order <b>#".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</b> was successfully completed.<br />
                            Amount Paid: <b>R".number_format($order->amount_paid,2)."</b><br /><br />
                            The Vendor will begin arranging collection / delivery of your product. 
                        "
                    ];
                    $comm->sendMail($data);
                }

                $vendor = Vendor::find($order->vendor_id);
                $order_data = "<table class='table-bodered'>";
                $order_data .= "<thead><tr><th style='text-align: left'>Item</th><th style='text-align: left'>Qty</th><th style='text-align: left'>Price</th></tr>";
                foreach($order->items AS $item){
                    $order_data .= "<tr>";
                    $order_data .= "<td>".$item->product->item_name."</td>";
                    $order_data .= "<td>".$item->quantity."</td>";
                    $order_data .= "<td>R".number_format($item->price,2)."</td>";
                    $order_data .= "</tr>";
                }
                $order_data .= "</table>";

                if($vendor){
                    $data = [
                        'name' => $vendor->user->name,
                        'to' => $vendor->user->email,
                        'subject' => 'Armoury Broker - New Order',
                        'message_body' => "
                            <b>You have a new order from armoury broker.</b><br />
                            ".$order_data."<br /><br />
                            Please <a href='".url('login')."'>login</a> to get order details and start the order delivery or collection process. 
                        "
                    ];
                    $comm->sendMail($data);
                }
            }
        }
    }

    public function pfPromoPayment($id){
        $pr = PromoCode::find($id);
        if($pr){
            $pr->payment_type = 'payfast_payment';
            $pr->payment_reff = Request::input('pf_payment_id');
            $pr->payment_status = Request::input('payment_status');
            $pr->save();
            return redirect('my-promo-codes')->with('message', 'Payment has been completed');
        }
    }

    public function approveWithDrawal($id){
        $wd = WithdrawalRequest::find($id);
        if($wd){
            $wd->verified = 1;
            $wd->save();
            return redirect('my-vault')->with('message', 'Withdrawal has been verified');
        }
    } 
}
