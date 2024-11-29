<?php

namespace App\Livewire\Home\Components;

use App\Models\Slider;
use Livewire\Component;

class SliderB extends Component
{
    public function render()
    {
        $sliders = Slider::query()->where('status',1)->get();
        return view('livewire.home.components.slider-b',[
            'sliders' =>$sliders,
        ]);
    }
}
