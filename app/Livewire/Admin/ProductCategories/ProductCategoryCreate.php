<?php

namespace App\Livewire\Admin\ProductCategories;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class ProductCategoryCreate extends Component
{
    public $saved = false;
    public $name,$slug,$show_at_home,$status;

    public function render()
    {
        return view('livewire.admin.product-categories.product-category-create');
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
            'name' => 'required|max:255|unique:categories,name',
            'status' => 'required|boolean',
            'show_at_home' => 'required|boolean',
        ],[
            'name.required' => 'Name Required ',
            'slug.required' => 'slug Required',
            'status.required' => 'status Required',
            'show_at_home.required' => 'show at home Required',
        ]);

        Category::insert([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'show_at_home' => $this->show_at_home,
            'status' => $this->status,
            'created_at' => Carbon::now(),
        ]);
        $this->alertSuccess('Product Categories inserted Successfully');
        return redirect()->to(route('admin.category.index'));
    }
}
