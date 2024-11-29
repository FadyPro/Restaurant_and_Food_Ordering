<?php

namespace App\Livewire\Home\Frontend;

use App\Models\About;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class AboutPage extends Component
{
    public function render()
    {
        $about = About::findOrFail(1);
        return view('livewire.home.frontend.about-page', compact('about'));
    }
}
