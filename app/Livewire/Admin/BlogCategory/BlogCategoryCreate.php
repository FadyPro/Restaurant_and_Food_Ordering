<?php

namespace App\Livewire\Admin\BlogCategory;

use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('layouts.admin.master')]
class BlogCategoryCreate extends Component
{
    public $saved = false;
    public $name,$slug,$status;

    public function render()
    {
        return view('livewire.admin.blog-category.blog-category-create');
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
            'name' => ['required', 'max:255', 'unique:blog_categories,name'],
            'status' => ['required', 'boolean'],
        ],[
            'name.required' => 'Name Required',
            'status.required' => 'Status Required',
        ]);

        $area = new BlogCategory();
        $area->name = $this->name;
        $area->slug = Str::slug($this->name);
        $area->status = $this->status;
        $area->save();

        $this->alertSuccess('Created Successfully');
        return redirect()->to(route('admin.blog-category.index'));
    }
}
