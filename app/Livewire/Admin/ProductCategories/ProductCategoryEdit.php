<?php

namespace App\Livewire\Admin\ProductCategories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.admin.master')]
class ProductCategoryEdit extends Component
{
    public $saved = false;
    public $name,$slug,$show_at_home,$status;
    public $category;
    public $model_id;

    public function mount($id)
    {
        $model = Category::query()->findOrFail($id);
        $this->category = $model;
        $this->model_id = $model->id;
        $this->name = $model->name;
        $this->slug = $model->slug;
        $this->status = $model->status;
        $this->show_at_home = $model->show_at_home;
    }
    public function render()
    {
        return view('livewire.admin.product-categories.product-category-edit');
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
            'name' => 'required|max:255|unique:categories,name,'.$this->model_id,
            'status' => 'required|boolean',
            'show_at_home' => 'required|boolean',
        ],[
            'name.required' => 'Name Required ',
            'slug.required' => 'slug Required',
            'status.required' => 'status Required',
            'show_at_home.required' => 'show at home Required',
        ]);
        $this->category->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'show_at_home' => $this->show_at_home,
            'status' => $this->status,
        ]);
        $this->saved = true;
        $this->alertSuccess('why choose us Successfully Updated');
        return redirect()->to(route('admin.category.index'));
    }
}
