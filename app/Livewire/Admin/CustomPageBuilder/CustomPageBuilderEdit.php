<?php

namespace App\Livewire\Admin\CustomPageBuilder;

use App\Models\CustomPageBuilder;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class CustomPageBuilderEdit extends Component
{
    public $saved = false;
    public $name,$content,$status;
    public $CustomPageBuilder,$model_id;

    public function mount($id)
    {
        $model = CustomPageBuilder::query()->findOrFail($id);
        $this->CustomPageBuilder = $model;
        $this->model_id = $id;
        $this->name = $model->name;
        $this->content = $model->content;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.custom-page-builder.custom-page-builder-edit');
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
            'product_id' => ['required', 'exists:products,id'],
            'status' => ['required', 'boolean'],
        ],[
            'product_id.required' => 'Product Required',
            'status.required' => 'Status Required',
        ]);

        $this->CustomPageBuilder->update([
            'name' => $this->name,
            'slug' => \Str::slug($this->name),
            'content' => $this->content,
            'status' => $this->status
        ]);
        $this->saved = true;

        $this->alertSuccess('Successfully Updated');
        return redirect()->to(route('admin.custom-page-builder.index'));
    }
}
