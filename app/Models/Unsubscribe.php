<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unsubscribe extends Model
{
    protected $fillable = [
        'user_id',
        'email',
    ];
}
