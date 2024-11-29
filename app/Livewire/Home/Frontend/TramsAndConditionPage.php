<?php

namespace App\Livewire\Home\Frontend;

use App\Models\TramsAndCondition;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class TramsAndConditionPage extends Component
{
    public function render()
    {
        $tramsAndConditions = TramsAndCondition::findOrFail(1);
        return view('livewire.home.frontend.trams-and-condition-page', compact('tramsAndConditions'));
    }
}
