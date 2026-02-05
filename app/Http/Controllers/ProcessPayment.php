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
use App\Models\CreditPayment;

class ProcessPayment extends Controller
{
    public function pfPayment($id){
        $order = Order::find($id);
        $wallet_pay = CreditPayment::where('order_id', $order->id)->first();

        $buyer = User::find($order->user_id);
        $seller = User::find($order->vendor_id);

        $stn_fee = Setting::where('name', 'service_fee')->first();
        $stn_min_fee = Setting::where('name', 'min_fee_amount')->first();

        if($order){
            if(strtolower(Request::input('payment_status')) == "complete"){
                if($wallet_pay){
                    $to_pay = $order->cart_total - $wallet_pay->amount;
                    if($to_pay != Request::input('amount_gross')){
                        dd("NOT PAID");
                    } 
                }
                elseif(Request::input('amount_gross') != $order->cart_total){
                    dd("Invalid amount");
                }
                
                $order->g_payment_id = Request::input('pf_payment_id');
                $order->amount_paid = Request::input('amount_gross');
                $order->status = Request::input('payment_status');
                $order->save();

                if($wallet_pay){
                    Transaction::create([
                        'name' => 'order_payment',
                        'transaction_type' => 'wallet_credit_payment',
                        'user_id' => $buyer->id,
                        'vendor_id' => $buyer->vendor_id,
                        'direction' => 'out',
                        'amount' => $wallet_pay->amount,
                        'order_id' => $order->id,
                        'order_item_id' => null,
                        'payment_status' => 'COMPLETE',
                    ]);
                }

                $fee_val = $stn_fee->value;
                foreach($order->items AS $item){
                    $product = $item->product;
                    
                    if($item->service_fee){
                        Transaction::create([
                            'name' => 'service_fee',
                            'transaction_type' => 'service_fee',
                            'user_id' => $buyer->id,
                            'vendor_id' => $buyer->vendor_id,
                            'direction' => 'out',
                            'amount' => $item->service_fee,
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'code' => '',
                            'payment_status' => 'COMPLETE',
                            'release' => null,
                        ]);
                    }
                    $fee = ($fee_val / 100) * $item->price;
                    if($product->service_fee_payer == "50-50"){
                        $fee = $fee / 2;
                    }
                    elseif($product->service_fee_payer == "buyer"){
                        $fee = 0;
                    }
                    if($fee){
                        Transaction::create([
                            'name' => 'service_fee',
                            'transaction_type' => 'service_fee',
                            'user_id' => $seller->id,
                            'vendor_id' => $seller->vendor_id,
                            'direction' => 'out',
                            'amount' => $fee,
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'code' => '',
                            'payment_status' => 'COMPLETE',
                            'release' => null,
                        ]);
                    }
                    $amount = $item->total_paid - ($fee + $item->service_fee);
                    Transaction::create([
                        'name' => 'order_payment',
                        'transaction_type' => 'payfast_payment',
                        'user_id' => $seller->id,
                        'vendor_id' => $seller->vendor_id,
                        'direction' => 'in',
                        'amount' => $amount,
                        'order_id' => $order->id,
                        'order_item_id' => $item->id,
                        'payment_status' => 'COMPLETE',
                    ]);

                    $offer = OfferPrice::where('user_id', $order->user_id)->where('product_id', $item->product_id)->whereNull('status')->first();
                    if($offer){
                        $offer->status = 1;
                        $offer->save();
                    }
                    $comm = new Communication();

                    $sold_price = ($item->total_paid - $item->shipping_price - $item->service_fee) / $item->quantity;
                    
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
                    $order_data .= "</tbody>";
                    $order_data .= "</table>";

                    if($item->shipping_method == "dealer_stock"){
                        if($item->dealer_option == "ab dealer"){
                            $dl = Dealer::find($item->ab_dealer_id);
                            if($dl){
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
                                $comm->sendMail($data);
                            }
                        }
                    }

                    $vnd = "<table><tr><td><b>Due to you</b></td><td><b>R ".number_format(($amount),2)."</b></td></tr><table>";

                    $body = "Looks like you have just helped someone to <b>LEVEL UP!</b><br /><br />
                    Great news! An order has been placed for an item currently listed in your Armoury.<br /><br />
                    ".$order_data.$vnd;
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
                        'to' => $seller->email,
                        'name' => $seller->name,
                        'subject' => 'Order Confirmation',
                        'title' => "Order Confirmation (AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT).")",
                        'message_body' => $body,
                        'cta' => true,
                        'cta_text' => 'View Order',
                        'cta_url' => url('my-orders'),
                        'after_cta_body' => $after,
                    ];
                    $comm->sendMail($data);

                    $slr = "<table><tr><td><b>Total paid</b></td><td><b>R ".number_format($item->total_paid,2)."</b></td></tr></table>";
                    $body = "Looks like you have just <b>LEVELED UP!</b><br /><br />
                    Great news! Your purchase has been confirmed, and your payment is now securely held in escrow. We've notified the seller to prepare your items for shipment.<br />
                    ".$order_data.$slr;

                    $after = "<b>What Happens Next?</b><br /><br />
                    <b>Seller prepares your order</b><br />
                    The seller has been notified and will prepare your items for delivery.<br /><br />
                    <b>Track your shipment</b><br />
                    The seller can add the tracking number to the purchase. Alternatively, send them a message to confirm.<br /><br />
                    <b>Confirm receipt</b><br />
                    When your order arrives, go to the \"My Purchases\" tab in your account and confirm receipt. This releases payment to the seller.";

                    $data = [
                        'to' => $buyer->email,
                        'name' => $buyer->name,
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
