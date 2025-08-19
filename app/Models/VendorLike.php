<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorLike extends Model
{
    protected $fillable = [
        'vendor_id',
        'user_id',
    ];
}
