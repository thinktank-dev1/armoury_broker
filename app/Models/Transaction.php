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
        'payment_status',
    ];
}
