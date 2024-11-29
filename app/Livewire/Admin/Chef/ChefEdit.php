<?php

namespace App\Livewire\Admin\Chef;

use App\Models\Chef;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class ChefEdit extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $image,$name,$title,$fb,$in,$x,$web,$show_at_home,$status;
    public $chef,$model_id;

    public function mount($id)
    {
        $model = Chef::findOrFail($id);
        $this->chef = $model;
        $this->model_id = $id;
        $this->name = $model->name;
        $this->title = $model->title;
        $this->fb = $model->fb;
        $this->in = $model->in;
        $this->x = $model->x;
        $this->web = $model->web;
        $this->show_at_home = $model->show_at_home;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.chef.chef-edit');
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

        if($this->image){
            @unlink(public_path('/uploads/chefs/'.$this->image));
            $imageName = uniqid() . '.' . $this->image->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->image);
            $image->resize(200,200)->toJpeg()->save(public_path('\uploads\chefs/'.$imageName));

//            $this->avatar->storeAs('uploads/admin_image', $imageName,'public_upload');
        }
        if ($this->image)
        {
            $this->chef->update([
                'image' => $imageName,
                'name' => $this->name,
                'title' => $this->title,
                'fb' => $this->fb,
                'in' => $this->in,
                'x' => $this->x,
                'web' => $this->web,
                'show_at_home' => $this->show_at_home,
                'status' => $this->status,
            ]);
        }else{
            $this->chef->update([
                'name' => $this->name,
                'title' => $this->title,
                'fb' => $this->fb,
                'in' => $this->in,
                'x' => $this->x,
                'web' => $this->web,
                'show_at_home' => $this->show_at_home,
                'status' => $this->status,
            ]);
        }
        $this->saved = true;
        $this->alertSuccess('Chef Updated Successfully');
        return redirect()->to(route('admin.chefs.index'));
    }
}
