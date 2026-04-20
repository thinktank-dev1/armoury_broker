<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\BlockVendor;
use App\Models\User;

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

    public function isBlocked(){
        $usr_1 = User::find($this->user_1);
        $usr_2 = User::find($this->user_2);
        $ch1 = BlockVendor::where('user_id', $usr_1->id)->where('vendor_id', $usr_2->vendor_id)->first();
        if($ch1){
            if(Auth::user()->id == $ch1->user_id){
                $arr = [
                    "blocked" => true,
                    "blocked_by" => "me",
                ];
            }
            else{
                $arr = [
                    "blocked" => true,
                    "blocked_by" => $usr_2->vendor->name,
                ];
            }
            return $arr;
        }
        $ch2 = BlockVendor::where('user_id', $usr_2->id)->where('vendor_id', $usr_1->vendor_id)->first();
        if($ch2){
            if(Auth::user()->id == $ch2->user_id){
                $arr = [
                    "blocked" => true,
                    "blocked_by" => "me",
                ];
            }
            else{
                $arr = [
                    "blocked" => true,
                    "blocked_by" => $user_1->vendor->name,
                ];
            }
            return $arr;
        }
        $arr = [
            "blocked" => false,
            "blocked_by" => null,
        ];
        return $arr;
    }
}
