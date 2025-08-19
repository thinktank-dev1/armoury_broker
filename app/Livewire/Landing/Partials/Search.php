<?php

namespace App\Livewire\Landing\Partials;

use Livewire\Component;

use Auth;
use App\Models\UserSearch;

class Search extends Component
{
    public $search_key;

    public function gotToShop(){
        if($this->search_key){
            if(!Auth::guest()){
                $ts = UserSearch::where('user_id', Auth::user()->id)->where('search_key', $this->search_key)->first();
                if(!$ts){
                    UserSearch::create([
                        'user_id' => Auth::user()->id,
                        'search_key' => $this->search_key,
                    ]);
                }
                else{
                    $ts->touch();
                }
            }
            return redirect('shop?search='.$this->search_key);
        }
    }

    public function render()
    {
        $searches = [];
        if(!Auth::guest()){
            $searches = UserSearch::where('user_id', Auth::user()->id)->orderBy('updated_at', 'DESC')->take(5)->get();
        }
        
        return view('livewire.landing.partials.search', [
            'searches' => $searches
        ]);
    }
}
