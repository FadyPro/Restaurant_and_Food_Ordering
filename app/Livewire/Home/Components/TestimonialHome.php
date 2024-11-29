<?php

namespace App\Livewire\Home\Components;

use App\Models\SectionTitles;
use App\Models\Testimonial;
use Livewire\Component;

class TestimonialHome extends Component
{
    public function render()
    {
        $sectionTitles = $this->getSectionTitles();
        $testimonials = Testimonial::where(['show_at_home' => 1, 'status' => 1])->get();
        return view('livewire.home.components.testimonial-home', compact('testimonials', 'sectionTitles'));
    }
    function getSectionTitles()
    {
        $keys = [
            'testimonial_top_title',
            'testimonial_main_title',
            'testimonial_sub_title',
        ];
        return SectionTitles::whereIn('key', $keys)->pluck('value','key');
    }
}
