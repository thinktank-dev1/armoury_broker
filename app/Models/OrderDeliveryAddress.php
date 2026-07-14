<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryAddress extends Model
{
    protected $fillable = [
        'terminal_id',
        'street', 
        'local_area', 
        'suburb', 
        'city', 
        'postal_code', 
        'province', 
        'type', 
        'longitude', 
        'latitude',
    ];
}
