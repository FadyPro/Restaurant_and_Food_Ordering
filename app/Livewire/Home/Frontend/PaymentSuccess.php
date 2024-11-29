<?php

namespace App\Livewire\Home\Frontend;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class PaymentSuccess extends Component
{
    public function render()
    {
        return view('livewire.home.frontend.payment-success');
    }
}
