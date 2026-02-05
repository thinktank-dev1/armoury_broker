<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditPayment extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'order_id',
        'amount',
        'order_status',
    ];
}
