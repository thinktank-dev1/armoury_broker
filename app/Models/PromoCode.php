<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'amount',
        'payment_type',
        'payment_reff',
        'payment_status',
        'status',
    ];
}
