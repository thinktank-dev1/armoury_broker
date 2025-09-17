<?php

namespace App\Livewire\Landing\Home;

use Livewire\Component;

use App\Models\Category;

class Categories extends Component
{
    public function render(){
        $categories = Category::where('featured', 1)->get();
        $other_cats = Category::where('featured', 0)->get();
        
        return view('livewire.landing.home.categories', [
            'categories' => $categories,
            'other_cats' => $other_cats
        ]);
    }
}
