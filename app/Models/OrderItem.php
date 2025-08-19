<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'order_id',
        'product_id',
        'price',
        'quantity',
        'discount',
        'promo_code',
        'shipping_id',
        'shipping_price',
        'service_fee',
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
