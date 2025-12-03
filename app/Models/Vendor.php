<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\OrderItem;

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

    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }

    public function sold(){
        return $this->order_items
        ->where('vendor_status', 'Order Dispatched')
        ->where('buyer_status', 'Received')
        ->count();
        // return $this->orders->whereNotNull('g_payment_id')->count();
    }

    public function transactions(){
        return $this->hasMany(Transaction::class, 'vendor_id');
    }

    public function withdrawal_requests(){
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function pending_withdrawal_balance(){
        return $this->withdrawal_requests->where('verified', 1)->where('status', 0)->sum('amount');
    }

    public function withdrawableBalance(){
        $pnd = $this->pending_withdrawal_balance();
        $tot_in = 0;
        $tot_out = 0;
        
        $trx_in = Transaction::query()
        ->where('vendor_id', $this->id)
        ->where(function($q){
            return $q->where('name', 'order_payment')
            ->orWhere('name', 'refund');
        })
        ->where('release', 1)
        ->get();

        foreach($trx_in AS $trx){
            $tot_in += $trx->amount;
        }
        $trx_out = Transaction::query()
        ->where('user_id', $this->user->id)
        ->where(function($q){
            return $q->where('name', 'withdrawal')
            ->orWhere('name', 'canceled_order')
            ->orWhere('transaction_type', 'wallet_payment');
        })
        ->where('release', 1)
        ->get();

        foreach($trx_out AS $trx){
            $tot_out += $trx->amount;
        }

        $tot = $tot_in - ($tot_out + $pnd);
        return $tot;
    }

    public function giftVoucherBalance(){
        $tot_in = 0;
        $tot_out = 0;
        /*
        foreach($this->transactions->where(function($q){
            return $q->where('transaction_type', 'voucher_balance')->orWhere('transaction_type', 'gift_voucher_payment');
        })->where('direction', 'in')->where('release', 1) AS $trx){
            $tot_in += $trx->amount;
        }
        foreach($this->transactions->where('transaction_type', 'gift_voucher_payment')->where('user_id', $this->user->id)->where('release', 1) AS $trx){
            $tot_out += $trx->amount;
        }
        // dd($tot_in,$tot_out);
        */

        $tot = $tot_in - $tot_out;
        return $tot;

    }

    public function balance(){
        $tot = $this->withdrawableBalance() + $this->giftVoucherBalance();
        return $tot;
    }

    public function average_delivery_time(){
        $avg = 0;
        $avg_items = OrderItem::query()
        ->where('vendor_id', $this->id)
        ->whereNotNull('receipt_date')
        ->selectRaw("
            DATEDIFF(receipt_date, created_at) AS days_between
            ")->get();

        $count = $avg_items->count();
        foreach($avg_items AS $itm){
            $avg += $itm->days_between;
        }
        if($count > 0 && $avg > 0){
            $dv = $avg/$count;
            return (int)$dv;
        }
        else{
            return 0;
        }
    }
}
