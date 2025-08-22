<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

use Auth;
use App\Models\WishList AS WishListModel;

class WishList extends Component
{
    #[Layout('components.layouts.landing')]
    public function render(){
        $lists = WishListModel::where('user_id', Auth::user()->id)->get();
        return view('livewire.landing.wish-list', [
            'lists' => $lists
        ]);
    }
}
