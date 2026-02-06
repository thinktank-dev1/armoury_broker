<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Setting;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'cart_total',
        'fee',
        'total_shipping_fee',

        'promo_code_id',
        'discount_amount',
        'promo_code',

        'vendor_promo_code',

        'g_payment_id',
        'uuid',
        'short_reference',
        'amount_paid',
        'status',
        'shipping_status',
        'receipt_status',
    ];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ab_fee(){
        $fee = 0;
        foreach($this->items AS $item){
            $fee += $item->service_fee;
        }
        return $fee;
    }

    public function shiping_fee(){
        $fee = 0;
        foreach($this->items AS $item){
            $fee += $item->shipping_price;
        }
        return $fee;
    }

    public function plartform_fees(){
        $fee_stn = Setting::where('name', 'service_fee')->first();
        $min_fee_stn = Setting::where('name', 'min_fee_amount')->first();

        $fee_val = $fee_stn->value;
        $min_fee_val = $min_fee_stn->value;

        $fee_arr = [
            'seller' => 0,
            'buyer' => 0,
        ];
        foreach($this->items AS $item){
            $fee = ($fee_val / 100) * ($item->price * $item->quantity);
            if($fee < $min_fee_val){
                $fee = $min_fee_val;
            }

            if($item->product->service_fee_payer == "buyer"){
                $fee_arr['buyer'] += $item->service_fee;
            }
            elseif($item->product->service_fee_payer == "buyer"){
                $fee_arr['seller'] += $fee;
            }
            else{
                $fee_arr['seller'] += $item->service_fee;
                $fee_arr['buyer'] += $item->service_fee;
            }
        }
        return $fee_arr;
    }
}
