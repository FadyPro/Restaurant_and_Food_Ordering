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
class BlogCreate extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $category_id,$image,$title,$slug,$description,$seo_title,$seo_description,$status;

    public function render()
    {
        $categories = BlogCategory::all();
        return view('livewire.admin.blog.blog-create',compact('categories'));
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
            'title' => ['required', 'max:255', 'unique:blogs,title'],
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

        $imageName = uniqid() . '.' . $this->image->extension();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->image);
        $image->resize(850,450)->toJpeg()->save(public_path('\uploads\blog/'.$imageName));

        $model = new Blog();
        $model->image = $imageName;
        $model->user_id = auth()->user()->id;
        $model->category_id = $this->category_id;
        $model->title = $this->title;
        $model->slug = Str::slug($this->title);
        $model->description = $this->description;
        $model->seo_title = $this->seo_title;
        $model->seo_description = $this->seo_description;
        $model->status = $this->status;
        $model->save();

        $this->alertSuccess('Blog Created Successfully');
        return redirect()->to(route('admin.blogs.index'));
    }
}
