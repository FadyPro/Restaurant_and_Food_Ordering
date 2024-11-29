<?php

namespace App\Livewire\Home\Components;

use App\Models\Counter;
use Livewire\Component;

class CountersHome extends Component
{
    public function render()
    {
        $counter = Counter::query()->first();
        return view('livewire.home.components.counters-home', compact('counter'));
    }
}
