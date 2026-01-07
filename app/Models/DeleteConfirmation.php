<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeleteConfirmation extends Model
{
    protected $fillable = [
        'token',
        'user_id',
    ];
}
