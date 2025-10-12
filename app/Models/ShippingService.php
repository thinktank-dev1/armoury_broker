<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingService extends Model
{
    protected $fillable = [
        'vendor_id',
        'name'
    ];
}
