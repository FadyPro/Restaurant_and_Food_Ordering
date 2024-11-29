<?php

namespace App\Livewire\Home\Components;

use App\Models\SectionTitles;
use App\Models\WhyChooseUs;
use Livewire\Component;

class WhyChooseUsSection extends Component
{
    public function render()
    {
        $sectionTitles = $this->getSectionTitles();
        $whyChooseUs = WhyChooseUs::query()->where('status',1)->get();
        return view('livewire.home.components.why-choose-us-section',[
            'whyChooseUs' =>$whyChooseUs,
            'sectionTitles' => $sectionTitles,
        ]);
    }
    function getSectionTitles() {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
            'daily_offer_top_title',
            'daily_offer_main_title',
            'daily_offer_sub_title',
            'chef_top_title',
            'chef_main_title',
            'chef_sub_title',
            'testimonial_top_title',
            'testimonial_main_title',
            'testimonial_sub_title'
        ];

        return SectionTitles::whereIn('key', $keys)->pluck('value','key');
    }
}
