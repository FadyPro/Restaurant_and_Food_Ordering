<?php

namespace App\Livewire\Home\Frontend;

use App\Models\PrivacyPolicy;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class PrivacyPolicyPage extends Component
{
    public function render()
    {
        $privacyPolicy = PrivacyPolicy::findOrfail(1);
        return view('livewire.home.frontend.privacy-policy-page', compact('privacyPolicy'));
    }
}
