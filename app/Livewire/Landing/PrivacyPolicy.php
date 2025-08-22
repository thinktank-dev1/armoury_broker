<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;

class PrivacyPolicy extends Component
{
    #[Layout('components.layouts.landing')]
    public function render()
    {
        return view('livewire.landing.privacy-policy');
    }
}
