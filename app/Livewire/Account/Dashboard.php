<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Livewire\WithFileUploads;

use Auth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Message;

class Dashboard extends Component
{
    use WithFileUploads;

    public $avatar;
    public $share_link;

    public $new_orders, $in_progress_orders, $completed_orders;
    public $new_purchases, $completed_purcahses;
    public $new_offers, $active_orders, $purchases_to_confirm;
    public $listing_count, $sold_listings;

    public function mount(){
        if(!Auth::user()->vendor_id && Auth::user()->role->name != "admin"){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
        }
        if(Auth::user()->vendor){
            $this->share_link = url(Auth::user()->vendor->url_name);
        }

        $this->getData();
    }

    public function getData(){
        $start_date = date('Y-m-1');
        $end_date = date("Y-m-t", strtotime($start_date));
        
        $this->new_orders = OrderItem::query()
        ->whereBetween('created_at', [$start_date, $end_date])
        ->where('vendor_id', Auth::user()->vendor_id)
        ->whereNotNull('order_id')
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->whereNull('vendor_status')
        ->whereNull('buyer_status')
        ->count();
        
        $this->in_progress_orders = OrderItem::query()
        ->whereBetween('created_at', [$start_date, $end_date])
        ->where('vendor_id', Auth::user()->vendor_id)
        ->whereNotNull('order_id')
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->where(function($q){
            return $q->where(function($qq){
                return $qq->whereNull('vendor_status')
                ->whereNotNull('buyer_status');
            })
            ->orWhere(function($qq){
                return $qq->whereNotNull('vendor_status')
                ->whereNull('buyer_status');
            });
        })
        ->count();

        $this->completed_orders = OrderItem::query()
        ->whereBetween('created_at', [$start_date, $end_date])
        ->where('vendor_id', Auth::user()->vendor_id)
        ->whereNotNull('order_id')
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->whereNotNull('vendor_status')
        ->whereNotNull('buyer_status')
        ->count();

        $this->new_purchases = OrderItem::query()
        ->whereBetween('created_at', [$start_date, $end_date])
        ->where('user_id', Auth::user()->id)
        ->whereNotNull('order_id')
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->whereNull('vendor_status')
        ->whereNull('buyer_status')
        ->count();

        $this->completed_purcahses = OrderItem::query()
        ->whereBetween('created_at', [$start_date, $end_date])
        ->where('user_id', Auth::user()->id)
        ->whereNotNull('order_id')
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->whereNotNull('vendor_status')
        ->whereNotNull('buyer_status')
        ->count();

        $this->new_offers = Message::query()
        ->whereHas('thread', function($q){
            return $q->where('user_1', Auth::user()->id);
        })
        ->where('read_status', 0)
        ->where('message', 'You have a new offer')
        ->count();

        $this->active_orders = OrderItem::query()
        ->where('vendor_id', Auth::user()->vendor_id)
        ->whereNotNull('order_id')
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->where(function($q){
            return $q->whereNull('vendor_status')
            ->orWhereNull('buyer_status');
        })
        ->count();

        $this->purchases_to_confirm = OrderItem::query()
        ->where('user_id', Auth::user()->id)
        ->whereNotNull('order_id')
        ->whereHas('order', function($q){
            return $q->whereNotNull('g_payment_id');
        })
        ->where(function($q){
            return $q->whereNotNull('vendor_status')
            ->whereNull('buyer_status');
        })
        ->count();

        $this->listing_count = Product::query()
        ->where('status', 1)
        ->where('user_id', Auth::user()->id)
        ->count();

        $this->sold_listings = Product::query()
        ->where('user_id', Auth::user()->id)
        ->whereHas('orders', function($q){
            return $q->whereHas('order', function($qq){
                return $qq->whereNotNull('g_payment_id');
            })
            ->whereNotNull('buyer_status')
            ->whereNotNull('vendor_status');
        })
        ->count();
    }

    public function copyLink(){
        if(Auth::user()->vendor){
            $link = url(Auth::user()->vendor->url_name);
            $this->link = $link;
            $this->dispatch('copy-link', link: $link);
        }
    }

    public function saveAvater(){
        if($this->avatar){
            $file = $this->avatar->storePublicly('vendor_avater', 'public');
            $vnd = Auth::user()->vendor;
            $vnd->avatar = $file;
            $vnd->save();
        }
        $this->avatar = null;
        $this->dispatch('close-modal');
    }

    public function render(){
        $ab_credit = 0;
        $gf_voucher = 0;
        $wd_funds = 0;
        $ord_progress = 0;
        $tot_balance = 0;

        return view('livewire.account.dashboard', [
            'ab_credit' => $ab_credit,
            'gf_voucher' => $gf_voucher,
            'wd_funds' => $wd_funds,
            'ord_progress' => $ord_progress,
            'tot_balance' => $tot_balance,
        ]);
    }
}
