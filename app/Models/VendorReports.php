<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorReports extends Model
{
    protected $fillable = [
        'vendor_id',
        'user_id',
        'description',
        'status',
    ];
}
