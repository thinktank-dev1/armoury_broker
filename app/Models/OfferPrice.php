<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferPrice extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
    ];
}
