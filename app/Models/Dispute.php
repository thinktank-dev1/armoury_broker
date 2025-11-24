<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'order_id',
        'message',
        'status',
    ];
}
