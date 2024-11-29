<?php

namespace App\Livewire\Admin\Testimonial;

use App\Models\Testimonial;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class TestimonialEdit extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $image,$name,$title,$rating,$review,$show_at_home,$status;
    public $testimonial,$model_id;

    public function mount($id)
    {
        $model = Testimonial::findOrFail($id);
        $this->testimonial = $model;
        $this->model_id = $id;
        $this->name = $model->name;
        $this->title = $model->title;
        $this->rating = $model->rating;
        $this->review = $model->review;
        $this->show_at_home = $model->show_at_home;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.testimonial.testimonial-edit');
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
            'image' => ['nullable', 'image'],
            'name' => ['required', 'max:255'],
            'title' => ['required', 'max:255'],
            'rating' => ['required', 'integer', 'max:5'],
            'review' => ['required', 'max:1000'],
            'show_at_home' => ['required', 'boolean'],
            'status' => ['required', 'boolean']
        ],[
            'image.required' => 'Image is required',
            'name.required' => 'Name is required',
            'title.required' => 'Title is required',
            'show_at_home.required' => 'Show At Home is required',
        ]);

        if($this->image){
            @unlink(public_path('/uploads/testimonial/'.$this->image));
            $imageName = uniqid() . '.' . $this->image->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->image);
            $image->resize(100,100)->toJpeg()->save(public_path('\uploads\testimonial/'.$imageName));

//            $this->avatar->storeAs('uploads/admin_image', $imageName,'public_upload');
        }
        if ($this->image)
        {
            $this->testimonial->update([
                'image' => $imageName,
                'name' => $this->name,
                'title' => $this->title,
                'rating' => $this->rating,
                'review' => $this->review,
                'show_at_home' => $this->show_at_home,
                'status' => $this->status,
            ]);
        }else{
            $this->testimonial->update([
                'name' => $this->name,
                'title' => $this->title,
                'rating' => $this->rating,
                'review' => $this->review,
                'show_at_home' => $this->show_at_home,
                'status' => $this->status,
            ]);
        }
        $this->saved = true;
        $this->alertSuccess('Testimonial Updated Successfully');
        return redirect()->to(route('admin.testimonial.index'));
    }
}
