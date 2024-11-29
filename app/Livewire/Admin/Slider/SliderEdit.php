<?php

namespace App\Livewire\Admin\Slider;

use App\Models\Slider;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class SliderEdit extends Component
{
    use WithFileUploads;
    public $saved = false;
    public $image,$offer,$title,$sub_title,$short_description,$button_link,$status;
    public $slider;
    public $model_id;

    public function mount($id)
    {
        $model = Slider::query()->findOrFail($id);
        $this->slider = $model;
        $this->model_id = $model->id;
        $this->offer = $model->offer;
        $this->title = $model->title;
        $this->sub_title = $model->sub_title;
        $this->short_description = $model->short_description;
        $this->button_link = $model->button_link;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.slider.slider-edit');
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
    public function updatedPhoto()
    {
        $this->validate([
            'avatar' => 'image|max:10'
        ]);
    }
    public function save()
    {
        $this->validate([
            'image' => 'nullable|image|max:3000|mimes:jpeg,jpg,png,gif',
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

        if($this->image){
            @unlink(public_path('/uploads/slider/'.$this->image));
            $imageName = uniqid() . '-' . time() . '.' . $this->image->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->image);
            $image->resize(550,550)->toJpeg()->save(public_path('\uploads\slider/'.$imageName));
//            $this->avatar->storeAs('uploads/admin_image', $imageName,'public_upload');
        }
        if ($this->image)
        {
            $this->slider->update([
                'offer' => $this->offer,
                'title' => $this->title,
                'sub_title' => $this->sub_title,
                'short_description' => $this->short_description,
                'button_link' => $this->button_link,
                'status' => $this->status,
                'image' => ($this->image ? $imageName: $this->slider->image)
            ]);
        }else{
            $this->slider->update([
                'offer' => $this->offer,
                'title' => $this->title,
                'sub_title' => $this->sub_title,
                'short_description' => $this->short_description,
                'button_link' => $this->button_link,
                'status' => $this->status,
            ]);
        }

        $this->saved = true;
        $this->alertSuccess('Slid Successfully Updated');
        return redirect()->to(route('admin.slider.index'));
    }
}
