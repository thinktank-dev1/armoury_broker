<?php

namespace App\Livewire\Landing;

use Livewire\Attributes\Layout;
use Livewire\Component;

class HomePage extends Component
{
    #[Layout('components.layouts.landing')] 
    public function render(){
        return view('livewire.landing.home-page');
    }
}
