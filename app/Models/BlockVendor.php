<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockVendor extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
    ];
}
