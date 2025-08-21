<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'url_name',
        'avatar',
        'banner',
        'description',
        'tel',
        'email',
        'street',
        'suburb',
        'city',
        'country',
        'status',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function likes(){
        return $this->hasMany(VendorLike::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
