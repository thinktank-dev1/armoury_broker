<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'product_id',
        'offer_amount',
        'status',
    ];
}
