<?php

namespace App\Livewire\Admin\CustomPageBuilder;

use App\Models\CustomPageBuilder;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class CustomPageBuilderCreate extends Component
{
    public $saved = false;
    public $name,$content,$status;

    public function render()
    {
        return view('livewire.admin.custom-page-builder.custom-page-builder-create');
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
            'name' => ['required', 'max:200', 'unique:custom_page_builders,name'],
            'content' => ['required'],
            'status' => ['required', 'boolean']
        ],[
            'name.required' => 'Name is required',
            'content.required' => 'Content is required',
            'status.required' => 'Status is required',
        ]);

        $area = new CustomPageBuilder();
        $area->name = $this->name;
        $area->slug = \Str::slug($this->name);
        $area->content = $this->content;
        $area->status = $this->status;
        $area->save();

        $this->alertSuccess('Created Successfully');
        return redirect()->to(route('admin.custom-page-builder.index'));
    }
}
