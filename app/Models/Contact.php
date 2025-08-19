<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'name', 
        'surname', 
        'email', 
        'contact_number', 
        'message'
    ];
}
