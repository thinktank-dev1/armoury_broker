<?php

namespace App\Http\Controllers;

use Request;

use App\Models\Order;
use App\Models\Transaction;

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
                Transaction::create([
                    'transaction_type' => 'payfast_payment',
                    'user_id' => $order->user_id,
                    'vendor_id' => $order->items->first()->vendor_id,
                    'direction' => 'in',
                    'amount' => Request::input('amount_gross'),
                    'order_id' => $order->id,
                    'payment_status' => Request::input('payment_status'),
                ]);
            }
        }
    } 
}
