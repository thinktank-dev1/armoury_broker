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

    public function balance(){
        $in = 0;
        $fee = 0;
        $stn = Setting::where('name', 'service_fee')->first();
        $sv_per = $stn->value;

        foreach($this->transactions->where('direction', 'in')->where('release', 1) AS $trx){
            if($trx->transaction_type == "voucher_balance"){
                $in += $trx->amount;
            }
            else{
                $item = $trx->item;
                if($item){
                    $product = $item->product;
                    if($product){
                        $i_fee = 0;
                        $amount = $item->price * $item->quantity;
                        if($product->service_fee_payer == "seller"){
                            $i_fee = ($sv_per / 100) * $amount;
                        }
                        if($product->service_fee_payer == "50-50"){
                            $sub_fee = ($sv_per / 100) * $amount;
                            $i_fee = (50/100) * $sub_fee;
                        }
                        $in += $amount;
                        $fee += $i_fee;
                    }
                }
            }
        }
        
        $out = $this->transactions->where('direction', 'out')->sum('amount');
        $balance = $in - ($fee + $out);
        return $balance;
    }
}
