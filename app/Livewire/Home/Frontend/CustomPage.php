<?php

namespace App\Livewire\Home\Frontend;

use App\Models\CustomPageBuilder;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class CustomPage extends Component
{
    public $page;

    public function mount($slug)
    {
        $this->page = CustomPageBuilder::query()->where(['slug' => $slug, 'status' => 1])->firstOrFail();;
    }
    public function render()
    {
        return view('livewire.home.frontend.custom-page');
    }
}
