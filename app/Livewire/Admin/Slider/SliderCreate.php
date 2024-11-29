<?php

namespace App\Livewire\Admin\Slider;

use App\Models\Slider;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class SliderCreate extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $image,
        $offer,
        $title,
        $sub_title,
        $short_description,
        $button_link,
        $status;

    public function render()
    {
        return view('livewire.admin.slider.slider-create');
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
            'image' => 'required|image|max:3000|mimes:jpeg,jpg,png,gif',
            'offer' => 'nullable|string|max:50',
            'title' => 'required|max:255',
            'sub_title' => 'required|max:255',
            'short_description' => 'required|max:255',
            'button_link' => 'nullable|max:255',
            'status' => 'boolean',
        ],[
            'image.required' => 'jpeg,jpg,png,gif',
            'title.required' => 'Title Required',
            'sub_title.required' => 'Sub Title Required',
            'short_description.required' => 'Short Description Required',
        ]);

        $imageName = uniqid() . '-' . time() . '.' . $this->image->extension();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->image);
        $image->resize(850,550)->toJpeg()->save(public_path('\uploads\slider/'.$imageName));
        Slider::insert([
            'image' => $imageName,
            'offer' => $this->offer,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'short_description' => $this->short_description,
            'button_link' => $this->button_link,
            'status' => $this->status,
            'created_at' => Carbon::now(),
        ]);
        $this->alertSuccess('Slid Inserted Successfully');
        return redirect()->to(route('admin.slider.index'));
    }
}
