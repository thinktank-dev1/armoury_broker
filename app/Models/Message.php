<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'from',
        'to',
        'name',
        'surname',
        'email',
        'contact_number',
        'message',
        'parent_id',
        'status',
    ];
}
