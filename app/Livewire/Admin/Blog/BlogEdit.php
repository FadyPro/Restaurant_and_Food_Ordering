<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class BlogEdit extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $category_id,$image,$title,$slug,$description,$seo_title,$seo_description,$status;
    public $Blog,$model_id;

    public function mount($id)
    {
        $model = Blog::query()->findOrFail($id);
        $this->Blog = $model;
        $this->model_id = $id;
        $this->user_id = $model->user_id;
        $this->category_id = $model->category_id;
        $this->title = $model->title;
        $this->slug = $model->slug;
        $this->description = $model->description;
        $this->seo_title = $model->seo_title;
        $this->seo_description = $model->seo_description;
        $this->status = $model->status;
    }
    public function render()
    {
        $categories = BlogCategory::all();
        return view('livewire.admin.blog.blog-edit',compact('categories'));
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
            'title' => ['required', 'max:255', 'unique:blogs,title,'. $this->model_id],
            'category_id' => ['required'],
            'description' => ['required'],
            'seo_title' => ['max:255'],
            'seo_description' => ['max:255'],
            'status' => ['required', 'boolean']
        ],[
            'image.required' => 'Image Required',
            'title.required' => 'Title Required',
            'category_id.required' => 'Category Required',
            'description.required' => 'Description Required',
            'status.required' => 'Status Required',
        ]);

        if($this->image){
            @unlink(public_path('/uploads/blog/'.$this->image));
            $imageName = uniqid() . '.' . $this->image->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->image);
            $image->resize(850,450)->toJpeg()->save(public_path('\uploads\blog/'.$imageName));
//            $this->avatar->storeAs('uploads/admin_image', $imageName,'public_upload');
        }
        if ($this->image)
        {
            $this->Blog->update([
                'user_id' => auth()->user()->id,
                'category_id' => $this->category_id,
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'seo_title' => $this->seo_title,
                'seo_description' => $this->seo_description,
                'status' => $this->status,
                'image' => $imageName
            ]);
        }else{
            $this->Blog->update([
                'user_id' => auth()->user()->id,
                'category_id' => $this->category_id,
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'seo_title' => $this->seo_title,
                'seo_description' => $this->seo_description,
                'status' => $this->status
            ]);
        }
        $this->saved = true;
        $this->alertSuccess('Blog Updated Successfully');
        return redirect()->to(route('admin.blogs.index'));
    }
}
