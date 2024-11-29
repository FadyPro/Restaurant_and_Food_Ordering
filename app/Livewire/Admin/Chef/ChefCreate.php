<?php

namespace App\Livewire\Admin\Chef;

use App\Models\Chef;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class ChefCreate extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $image,$name,$title,$fb,$in,$x,$web,$show_at_home,$status;

    public function render()
    {
        return view('livewire.admin.chef.chef-create');
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
            'fb' => ['nullable','max:255', 'url'],
            'in' => ['nullable', 'max:255', 'url'],
            'x' => ['nullable', 'max:255', 'url'],
            'web' => ['nullable', 'max:255', 'url'],
            'show_at_home' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ],[
            'image.required' => 'Image is required',
            'name.required' => 'Name is required',
            'title.required' => 'Title is required',
            'show_at_home.required' => 'Show At Home is required',
        ]);

        $imageName = uniqid() . '.' . $this->image->extension();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->image);
        $image->resize(200,200)->toJpeg()->save(public_path('\uploads\chefs/'.$imageName));

        $model = new Chef();
        $model->image = $imageName;
        $model->name = $this->name;
        $model->title = $this->title;
        $model->fb = $this->fb;
        $model->in = $this->in;
        $model->x = $this->x;
        $model->web = $this->web;
        $model->show_at_home = $this->show_at_home;
        $model->status = $this->status;
        $model->save();

        $this->alertSuccess('Chef Created Successfully');
        return redirect()->to(route('admin.chefs.index'));
    }
}
