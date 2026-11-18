<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDoc extends Model
{
    protected $fillable = [
        'name', 
        'link_url'
    ];
}
