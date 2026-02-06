<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'user_1',
        'user_2',
        'order_id',
        'item_id',
        'message',
        'user_1_status',
        'user_2_status',
    ];

    public function item(){
        return $this->belongsTo(OrderItem::class, 'item_id');
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function user1(){
        return $this->belongsTo(User::class, 'user_1');
    }

    public function user2(){
        return $this->belongsTo(User::class, 'user_2');
    }
}
