<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.home.master')]
class Home extends Component
{

    public function render()
    {
        return view('livewire.home.home');
    }

}
