<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'business_name',
        'business_reg_number', 
        'vat_number',
        'license_number',

        'street',
        'suburb',
        'town',
        'postal_code',
        'province',
        'billing_contact',
        'billing_email',
        'billing_contact_number',
         
        'dealer_stocking_fee', 
        'ab_dealer_network_agreement', 
        'license_agreement', 
        'fee_agreement'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
