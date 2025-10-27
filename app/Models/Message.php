<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'message_thread_id',
        'user_id',
        'message',
        'offer_amount',
        'action',
        'read_status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread(){
        return $this->belongsTo(MessageThread::class, 'message_thread_id');
    }
}
