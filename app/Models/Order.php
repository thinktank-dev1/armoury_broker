<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
