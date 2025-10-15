<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MessageThread extends Model
{
    protected $fillable = [
        'user_1',
        'user_2',
        'product_id',
        'order_id',
        'order_item_id',
        'name',
        'surname',
        'email',
        'contact_number',
    ];

    public function messages(){
        return $this->hasMany(Message::class)->orderBy('created_at', 'ASC');
    }

    public function user(){
        if(!Auth::guest()){
            if(Auth::user()->id != $this->user_1){
                return $this->belongsTo(User::class, 'user_1');
            }
            else{
                return $this->belongsTo(User::class, 'user_2');
            }
        }
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
