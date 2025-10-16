<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Setting;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'url_name',
        'avatar',
        'banner',
        'description',
        'suburb',
        'city',
        'province',
        'instagram_handle',
        'status',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function likes(){
        return $this->hasMany(VendorLike::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function sold(){
        return $this->orders->whereNotNull('g_payment_id')->count();
    }

    public function transactions(){
        return $this->hasMany(Transaction::class, 'vendor_id');
    }

    public function withdrawableBalance(){
        $tot_in = 0;
        $tot_out = 0;
        foreach($this->transactions->where('name', 'order_payment')->where('direction', 'in')->where('release', 1) AS $trx){
            $tot_in += $trx->amount;
        }
        foreach($this->transactions->where(function($q){
            return $q->where('transaction_type', 'wallet_payment')
            ->orWhere('transaction_type', 'withdrawal');
        })->where('user_id', $this->user->id)->where('release', 1) AS $trx){
            $tot_out += $trx->amount;
        }

        $tot = $tot_in - $tot_out;
        return $tot;
    }

    public function giftVoucherBalance(){
        $tot_in = 0;
        $tot_out = 0;
        foreach($this->transactions->where(function($q){
            return $q->where('transaction_type', 'voucher_balance')->orWhere('transaction_type', 'gift_voucher_payment');
        })->where('direction', 'in')->where('release', 1) AS $trx){
            $tot_in += $trx->amount;
        }
        foreach($this->transactions->where('transaction_type', 'gift_voucher_payment')->where('user_id', $this->user->id)->where('release', 1) AS $trx){
            $tot_out += $trx->amount;
        }
        // dd($tot_in,$tot_out);

        $tot = $tot_in - $tot_out;
        return $tot;

    }

    public function balance(){
        $tot = $this->withdrawableBalance() + $this->giftVoucherBalance();
        return $tot;
    }
}
