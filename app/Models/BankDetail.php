<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $fillable = [
        'user_id',
        'bank_name', 
        'branch_code', 
        'account_number', 
        'branch_name', 
        'account_holder'
    ];
}
