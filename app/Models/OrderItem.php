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
        'collection_free_shipping',

        'shiping_service',
        'tracking_number',

        'deliver_collection',
        'delivery_address',
        'dealer_option',
        'ab_dealer_id',
        'custom_dealer_details',

        'vendor_status',
        'dispatch_date',

        'buyer_status',
        'receipt_date',
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function courier(){
        return $this->belongsTo(DeliverOption::class, 'shipping_id');
    }

    public function dealer(){
        return $this->belongsTo(Dealer::class, 'ab_dealer_id');
    }
}
