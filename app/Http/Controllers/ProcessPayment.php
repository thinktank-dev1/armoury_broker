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
use App\Models\Dealer;
use App\Models\OfferPrice;

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
                
                if(Request::has('custom_str1') && Request::input('custom_str1') === "partial"){
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
                        
                        $amount = $item->amount_paid;
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
                        $offer = OfferPrice::where('user_id', $order->user_id)->where('product_id', $item->product_id)->whereNull('status')->first();
                        if($offer){
                            $offer->status = 1;
                            $offer->save();
                        }

                        if($item->shipping_method == "dealer_stock"){
                            if($item->dealer_option == "ab dealer"){
                                $dl = Dealer::find($item->ab_dealer_id);
                                
                                if($dl){
                                    $order_data = "<table class='table-bodered' style='width: 100%'>";
                                    $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</th></tr></thead>";
                                    $order_data .= "<tbody>";
                                    $order_data .= "<tr>";
                                    if($item->product->images->count() > 0){
                                        $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$item->product->images->first()->image_url)."'></td>";
                                    }
                                    else{
                                        $order_data .= "<td></td>";
                                    }
                                    
                                    $sold_price = ($item->total_paid - $item->shipping_price - $item->service_fee) / $item->quantity;
                                                    
                                    $order_data .= "<td>";
                                    $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
                                    $order_data .= "<tr><td>Order Date:</td><td>".date('Y-m-d', strtotime($item->created_at))."</td></tr>";
                                    $order_data .= "<tr><td>Item Name:</td><td>".$item->product->item_name."</td></tr>";
                                    $order_data .= "<tr><td>Quantity:</td><td>".$item->quantity."</td></tr>";
                                    $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($item->product->item_price,2)."</td></tr>";
                                    $order_data .= "<tr><td>Sold Price:</td><td>R ".number_format($sold_price,2)."</td></tr>";
                                    $order_data .= "<tr><td>Discount Applied:</td><td>".$item->discount."</td></tr>";
                                    $order_data .= "<tr><td>Delivery Type:</td><td>".ucwords(str_replace('_', ' ',$item->shipping_method))."</td></tr>";
                                    $order_data .= "</table>";
                                    $order_data .= "</td>";
                                    $order_data .= "</tr>";
                                    $order_data .= "</table>";

                                    $dl_user = $dl->user;

                                    $body = "RE: Dealer Stocking Request for <b>".$item->user->vendor->name."</b><br /><br />
                                    A platform user has selected your business to stock a firearm while they apply for the relevant license under the Firearms Control Act 60 of 2000.<br /><br />
                                    The details of the transaction are as follows:".$order_data;
                                    $body .= "<br /><b>What Happens Next?</b><br />
                                    The buyer and seller will contact you to arrange delivery of the item to your location.";

                                    $data = [
                                        'to' => $dl_user->email,
                                        'name' => $dl_user->name,
                                        'subject' => 'Dealer Stocking Confirmation',
                                        'title' => "Dealer Stocking Confirmation",
                                        'message_body' => $body,
                                        'cta' => false,
                                        'cta_text' => null,
                                        'cta_url' => null,
                                        'after_cta_body' => null,
                                    ];
                                    $comm = new Communication();
                                    $comm->sendMail($data);

                                }
                            }
                        }
                    }
                }

                $comm = new Communication();

                $vendor = Vendor::find($order->vendor_id);
                if($vendor){
                    $order_data = "<table class='table-bodered' style='width: 100%'>";
                    $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</th></tr></thead>";
                    $order_data .= "<tbody>";
                    foreach($order->items AS $item){
                        $order_data .= "<tr>";
                        if($item->product->images->count() > 0){
                            $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$item->product->images->first()->image_url)."'></td>";
                        }
                        else{
                            $order_data .= "<td></td>";
                        }

                        $sold_price = ($item->total_paid - $item->shipping_price - $item->service_fee) / $item->quantity;

                        $order_data .= "<td>";
                        $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
                        $order_data .= "<tr><td>Order Date:</td><td>".date('Y-m-d', strtotime($item->created_at))."</td></tr>";
                        $order_data .= "<tr><td>Item Name:</td><td>".$item->product->item_name."</td></tr>";
                        $order_data .= "<tr><td>Quantity:</td><td>".$item->quantity."</td></tr>";
                        $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($item->product->item_price,2)."</td></tr>";
                        $order_data .= "<tr><td>Sold Price:</td><td>R ".number_format($sold_price,2)."</td></tr>";
                        $order_data .= "<tr><td>Discount Applied:</td><td>".$item->discount."</td></tr>";
                        $order_data .= "<tr><td>Delivery Type:</td><td>".ucwords(str_replace('_', ' ',$item->shipping_method))."</td></tr>";
                        $order_data .= "</table>";
                        $order_data .= "</td>";
                        $order_data .= "</tr>";
                    }
                    $order_data .= "<tr><td><b>Due to you</b></td><td><b>R ".number_format(($order->cart_total + $order->total_shipping_fee),2)."</b></td></tr>";
                    $order_data .= "</table>";

                    $body = "Looks like you have just helped someone to <b>LEVEL UP!</b><br /><br />
                    Great news! An order has been placed for an item currently listed in your Armoury.<br /><br />
                    ".$order_data;
                    $after = "<b>Next steps for your order:</b><br /><br />
                    <b>Payment received</b><br />
                    We've received full payment from the buyer and are holding the funds in escrow.<br /><br />
                    <b>Check delivery details</b><br />
                    Go to the \"My Orders\" tab on the Armoury Broker platform to view the buyer's delivery or collection requirements.<br /><br />
                    <b>Arrange and confirm delivery</b><br />
                    Once you've arranged delivery or collection, update the order status to:<br />
                    <ul>
                        <li>\"Order Dispatched\" for general items</li>
                        <li>\"Dealer Stocked\" for firearms</li>
                    </ul><br />
                    <b>Funds release</b><br />
                    Once the buyer confirms receipt (or the item is dealer stocked), we'll release the funds to your Armoury Broker Vault.";

                    $data = [
                        'to' => $vendor->user->email,
                        'name' => $vendor->user->name,
                        'subject' => 'Order Confirmation',
                        'title' => "Order Confirmation (AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT).")",
                        'message_body' => $body,
                        'cta' => true,
                        'cta_text' => 'View Order',
                        'cta_url' => url('my-orders'),
                        'after_cta_body' => $after,
                    ];
                    $comm->sendMail($data);
                }
                $user = User::find($order->user_id);
                if($user){
                    $order_data = "<table class='table-bodered' style='width: 100%'>";
                    $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</th></tr></thead>";
                    $order_data .= "<tbody>";
                    foreach($order->items AS $item){
                        $order_data .= "<tr>";
                        if($item->product->images->count() > 0){
                            $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$item->product->images->first()->image_url)."'></td>";
                        }
                        else{
                            $order_data .= "<td></td>";
                        }

                        $sold_price = ($item->total_paid - $item->shipping_price - $item->service_fee) / $item->quantity;

                        $order_data .= "<td>";
                        $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
                        $order_data .= "<tr><td>Order Date:</td><td>".date('Y-m-d', strtotime($item->created_at))."</td></tr>";
                        $order_data .= "<tr><td>Item Name:</td><td>".$item->product->item_name."</td></tr>";
                        $order_data .= "<tr><td>Quantity:</td><td>".$item->quantity."</td></tr>";
                        $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($item->product->item_price,2)."</td></tr>";
                        $order_data .= "<tr><td>Sold Price:</td><td>R ".number_format($sold_price,2)."</td></tr>";
                        $order_data .= "<tr><td>Discount Applied:</td><td>".$item->discount."</td></tr>";
                        $order_data .= "<tr><td>Delivery Type:</td><td>".$item->shipping_method."</td></tr>";
                        $order_data .= "</table>";
                        $order_data .= "</td>";
                        $order_data .= "</tr>";
                    }
                    $order_data .= "<tr><td><b>Total paid</b></td><td><b>R ".number_format($tot,2)."</b></td></tr>";
                    $order_data .= "</table>";

                    $body = "Looks like you have just <b>LEVELED UP!</b><br /><br />
                    Great news! Your purchase has been confirmed, and your payment is now securely held in escrow. We've notified the seller to prepare your items for shipment.<br />
                    ".$order_data;

                    $after = "<b>What Happens Next?</b><br /><br />
                    <b>Seller prepares your order</b><br />
                    The seller has been notified and will prepare your items for delivery.<br /><br />
                    <b>Track your shipment</b><br />
                    The seller can add the tracking number to the purchase. Alternatively, send them a message to confirm.<br /><br />
                    <b>Confirm receipt</b><br />
                    When your order arrives, go to the \"My Purchases\" tab in your account and confirm receipt. This releases payment to the seller.";

                    $data = [
                        'to' => $user->email,
                        'name' => $user->name,
                        'subject' => 'Purchase Confirmation',
                        'title' => "Congratulations on your purchase",
                        'message_body' => $body,
                        'cta' => true,
                        'cta_text' => 'View Purchase',
                        'cta_url' => url('my-purchases'),
                        'after_cta_body' => $after,
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
