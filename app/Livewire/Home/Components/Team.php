<?php

namespace App\Livewire\Home\Components;

use App\Models\Chef;
use App\Models\SectionTitles;
use Livewire\Component;

class Team extends Component
{
    public function render()
    {
        $sectionTitles = $this->getSectionTitles();
        $chefs = Chef::where(['show_at_home' => 1, 'status' => 1])->get();
        return view('livewire.home.components.team', compact('chefs', 'sectionTitles'));
    }
    function getSectionTitles()
    {
        $keys = [
            'chef_top_title',
            'chef_main_title',
            'chef_sub_title',
        ];
        return SectionTitles::whereIn('key', $keys)->pluck('value','key');
    }
}
