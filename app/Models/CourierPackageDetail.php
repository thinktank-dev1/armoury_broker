<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierPackageDetail extends Model
{
    protected $fillable = [
        'product_id',
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
        'length_cm', 
        'width_cm', 
        'height_cm', 
        'weight_kg',
    ];
}
