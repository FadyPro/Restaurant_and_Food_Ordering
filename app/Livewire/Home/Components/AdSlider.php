<?php

namespace App\Livewire\Home\Components;

use App\Models\BannerSlider;
use Livewire\Component;

class AdSlider extends Component
{
    public function render()
    {
        $bannerSliders = BannerSlider::where('status', 1)->latest()->take(10)->get();
        return view('livewire.home.components.ad-slider', compact('bannerSliders'));
    }
}
