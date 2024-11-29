<?php

namespace App\Livewire\Home\Components;

use App\Models\AppDownloadSection;
use Livewire\Component;

class AppDownload extends Component
{
    public function render()
    {
        $appSection = AppDownloadSection::first();
        return view('livewire.home.components.app-download',compact('appSection'));
    }
}
