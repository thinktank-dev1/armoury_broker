<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'business_name', 
        'license_number', 
        'business_street', 
        'business_suburb', 
        'business_city',
        'business_postal_code', 
        'business_province', 
        'dealer_stocking_fee', 
        'ab_dealer_network_agreement', 
        'license_agreement', 
        'fee_agreement'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
