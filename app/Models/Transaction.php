<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_type',
        'user_id',
        'vendor_id',
        'direction',
        'amount',
        'order_id',
        'order_item_id',
        'payment_status',
        'release',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function item(){
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }
}
