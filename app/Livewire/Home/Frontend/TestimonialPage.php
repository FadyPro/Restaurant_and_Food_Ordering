<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Chef;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class TestimonialPage extends Component
{
    public function render()
    {
        $testimonials = Testimonial::query()->where(['status' => 1])->paginate(12);
        return view('livewire.home.frontend.testimonial-page',compact('testimonials'));
    }
}
