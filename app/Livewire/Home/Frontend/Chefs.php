<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Chef;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class Chefs extends Component
{
    public function render()
    {

        $chefs = Chef::where(['status' => 1])->paginate(12);
        return view('livewire.home.frontend.chefs', compact('chefs'));
    }
}
