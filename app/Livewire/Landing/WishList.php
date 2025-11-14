<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Auth;
use App\Models\WishList AS WishListModel;
use App\Models\VendorLike;

class WishList extends Component
{
    public $cur_view;

    public function mount(){
        $this->cur_view = "items";
    }

    public function changeView($view){
        $this->cur_view = $view;
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        $lists = WishListModel::where('user_id', Auth::user()->id)->get();
        $liked_stores = VendorLike::where('user_id', Auth::user()->id)->get();
        return view('livewire.landing.wish-list', [
            'lists' => $lists,
            'liked_stores' => $liked_stores
        ]);
    }
}
