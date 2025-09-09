<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorPromoCode extends Model
{
    protected $fillable = [
        'vendor_id',
        'description',
        'code',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'type', //Amount or percentage
        'value',
        'status',
        'deleted',
    ];
}
