<?php

namespace App\Livewire\Account;

use Livewire\Component;

use Auth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class Dashboard extends Component
{
    public $orders, $listed, $purchases;

    public function mount(){
        if(!Auth::user()->vendor_id && Auth::user()->role->name != "admin"){
            return redirect('my-armoury/edit')->with('error', 'Please fill in this form before you can upload products!');
        }
        $this->getData();
    }

    public function getData(){
        $this->orders = Order::where('vendor_id', Auth::user()->vendor_id)->count();
        $this->listed = Product::where('vendor_id', Auth::user()->vendor_id)->count();
        $this->purchases = Order::where('user_id', Auth::user()->id)->count();
    }

    public function render(){
        $order_items = OrderItem::where('vendor_id', Auth::user()->vendor_id)->orderBy('created_at', 'DESC')->take(5)->get();
        $purcahse_items = OrderItem::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->take(5)->get();
        
        return view('livewire.account.dashboard', [
            'order_items' => $order_items,
            'purcahse_items' => $purcahse_items
        ]);
    }
}
