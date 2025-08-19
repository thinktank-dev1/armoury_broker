<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliverOption extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'price',
    ];
}
