<?php

namespace App\Livewire\Admin\WhyChooseUs;

use App\Models\WhyChooseUs;
use Carbon\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class WhyChooseUsCreate extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $icon,$title,$short_description,$status;
    public function render()
    {
        return view('livewire.admin.why-choose-us.why-choose-us-create');
    }
    public function alertSuccess($rel)
    {
        $this->dispatch('alert',
            ['types' => 'success',  'message' => $rel]);
    }
    public function alertDelete($rel)
    {
        $this->dispatch('alert',
            ['types' => 'error',  'message' => $rel]);
    }
    public function save()
    {
        $this->validate([
            'icon' => 'required',
            'title' => 'required|max:255',
            'short_description' => 'required|max:255',
            'status' => 'required|boolean',
        ],[
            'icon.required' => 'required https://fontawesome.com/icons',
            'title.required' => 'Title Required',
            'short_description.required' => 'Short Description Required',
        ]);

        WhyChooseUs::insert([
            'icon' => $this->icon,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'status' => $this->status,
            'created_at' => Carbon::now(),
        ]);
        $this->alertSuccess('why choose us inserted Successfully');
        return redirect()->to(route('admin.why-choose-us.index'));
    }
}
