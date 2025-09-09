<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'order_item_id',
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

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function parent(){
        return $this->belongsTo(Message::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Message::class, 'parent_id');
    }

    public function fromUser(){
        return $this->belongsTo(User::class, 'from');
    }
}
