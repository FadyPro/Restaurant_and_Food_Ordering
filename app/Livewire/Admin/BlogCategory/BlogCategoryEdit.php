<?php

namespace App\Livewire\Admin\BlogCategory;

use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('layouts.admin.master')]
class BlogCategoryEdit extends Component
{
    public $saved = false;
    public $name,$status;
    public $BlogCategory,$model_id;

    public function mount($id)
    {
        $model = BlogCategory::query()->findOrFail($id);
        $this->BlogCategory = $model;
        $this->model_id = $id;
        $this->name = $model->name;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.blog-category.blog-category-edit');
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
            'name' => ['required', 'max:255', 'unique:blog_categories,name,'.$this->model_id],
            'status' => ['required', 'boolean'],
        ],[
            'name.required' => 'Name Required',
            'status.required' => 'Status Required',
        ]);

        $this->BlogCategory->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'status' => $this->status
        ]);
        $this->saved = true;

        $this->alertSuccess('Successfully Updated');
        return redirect()->to(route('admin.blog-category.index'));
    }
}
