<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $fillable = [
        'vendor_id',
        'amount', 
        'bank_name', 
        'branch_name', 
        'branch_code', 
        'account_name', 
        'account_number',
        'verified',
        'status',
    ];

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
}
