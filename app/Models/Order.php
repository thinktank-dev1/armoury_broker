<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'cart_total',
        'fee',
        'total_shipping_fee',
        'payment_id',
        'uuid',
        'short_reference',
        'amount_paid',
        'status',
    ];
}
