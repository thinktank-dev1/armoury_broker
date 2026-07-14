<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PudoSize extends Model
{
    protected $fillable = [
        'name',
        'width',
        'height',
        'length',
        'max_weight',
    ];
}
