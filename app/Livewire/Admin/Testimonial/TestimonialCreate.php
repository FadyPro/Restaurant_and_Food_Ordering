<?php

namespace App\Livewire\Admin\Testimonial;

use App\Models\Testimonial;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class TestimonialCreate extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $image,$name,$title,$rating,$review,$show_at_home,$status;

    public function render()
    {
        return view('livewire.admin.testimonial.testimonial-create');
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
            'image' => ['required', 'image'],
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

        $imageName = uniqid() . '.' . $this->image->extension();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->image);
        $image->resize(100,100)->toJpeg()->save(public_path('\uploads\testimonial/'.$imageName));

        $model = new Testimonial();
        $model->image = $imageName;
        $model->name = $this->name;
        $model->title = $this->title;
        $model->rating = $this->rating;
        $model->review = $this->review;
        $model->show_at_home = $this->show_at_home;
        $model->status = $this->status;
        $model->save();

        $this->alertSuccess('Testimonial Created Successfully');
        return redirect()->to(route('admin.testimonial.index'));
    }
}
