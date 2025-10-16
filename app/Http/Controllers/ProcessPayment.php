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
use App\Models\Setting;

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
                
                if(Request::has('custom_str1')){
                    $amount = $tot;
                    // $amount = $this->fee_payment($amount, $order, null, $order->cart_total);
                    Transaction::create([
                        'name' => 'order_payment',
                        'transaction_type' => 'payfast_payment',
                        'user_id' => $order->user_id,
                        'vendor_id' => $order->vendor_id,
                        'direction' => 'in',
                        'amount' => $amount,
                        'order_id' => $order->id,
                        'order_item_id' => null,
                        'payment_status' => 'Partial Payment',
                    ]);
                }
                else{
                    foreach($order->items AS $item){
                        $amount = $item->price * $item->quantity;
                        
                        $amount = $this->fee_payment($amount,$order,$item);
                        Transaction::create([
                            'name' => 'order_payment',
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

    public function fee_payment($amount, $order, $item = null, $ct = null){
        $fee_rate = 5;
        $min_fee = 25;
        $stn_fee = Setting::where('name', 'service_fee')->first();
        $stn_min_fee = Setting::where('name', 'min_fee_amount')->first();
        if($stn_fee){
            $fee_rate = $stn_fee->value;
        }
        if($stn_min_fee){
            $min_fee = $stn_min_fee->value;
        }
        if($item){
            $prdt = $item->product;
        }
        if($prdt->service_fee_payer == "buyer"){
            if($ct){
                $fee = ($fee_rate / 100) * $ct;
            }
            else{
                $fee = ($fee_rate / 100) * $amount;
            }
            if($fee < $min_fee){
                $fee = $min_fee;
            }
            $usr = User::find($order->user_id);
            Transaction::create([
                'name' => 'service_fee',
                'transaction_type' => 'service_fee',
                'user_id' => $usr->id,
                'vendor_id' => $usr->vendor_id,
                'direction' => 'out',
                'amount' => $fee,
                'order_id' => $order->id,
                'order_item_id' => $item->id ?? null,
                'code' => '',
                'payment_status' => 'COMPLETE',
                'release' => null,
            ]);
        }
        elseif($prdt->service_fee_payer == "seller"){
            if($ct){
                $fee = ($fee_rate / 100) * $ct;
            }
            else{
                $fee = ($fee_rate / 100) * $amount;
            }
            if($fee < $min_fee){
                $fee = $min_fee;
            }
            $amount -= $fee;
            $usr = User::where('vendor_id', $order->vendor_id)->first();
            Transaction::create([
                'name' => 'service_fee',
                'transaction_type' => 'service_fee',
                'user_id' => $usr->id,
                'vendor_id' => $usr->vendor_id,
                'direction' => 'out',
                'amount' => $fee,
                'order_id' => $order->id,
                'order_item_id' => $item->id ?? null,
                'code' => '',
                'payment_status' => 'COMPLETE',
                'release' => null,
            ]);
        }
        elseif($prdt->service_fee_payer == "50-50"){
            if($ct){
                $fee = ($fee_rate / 100) * $ct;
            }
            else{
                $fee = ($fee_rate / 100) * $amount;
            }
            if($fee < $min_fee){
                $fee = $min_fee;
            }
            $fee = $fee / 2;
            $amount -= $fee;

            $vnd = User::where('vendor_id', $order->vendor_id)->first();
            Transaction::create([
                'name' => 'service_fee',
                'transaction_type' => 'service_fee',
                'user_id' => $vnd->id,
                'vendor_id' => $vnd->vendor_id,
                'direction' => 'out',
                'amount' => $fee,
                'order_id' => $order->id,
                'order_item_id' => $item->id ?? null,
                'code' => '',
                'payment_status' => 'COMPLETE',
                'release' => null,
            ]);
            $usr = User::find($order->user_id);
            Transaction::create([
                'name' => 'service_fee',
                'transaction_type' => 'service_fee',
                'user_id' => $usr->id,
                'vendor_id' => $usr->vendor_id,
                'direction' => 'out',
                'amount' => $fee,
                'order_id' => $order->id,
                'order_item_id' => $item->id ?? null,
                'code' => '',
                'payment_status' => 'COMPLETE',
                'release' => null,
            ]);
        }
        return $amount;
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
