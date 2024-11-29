<?php

namespace App\Livewire\Admin\TramsAndCondition;

use App\Models\TramsAndCondition;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class TramsAndConditionIndex extends Component
{
    public $saved = false;
    public $content;

    public function mount()
    {
        $model = TramsAndCondition::findOrFail(1);
        $this->terms = $model;
        $this->content = $model->content;
    }
    public function render()
    {
        return view('livewire.admin.trams-and-condition.trams-and-condition-index');
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
            'content' => ['required'],
        ],[
            'content.required' => 'The content field is required.',
        ]);
        TramsAndCondition::updateOrCreate(
            ['id' => 1],
            [
                'content' => $this->content,
            ]
        );
        $this->alertSuccess('terms and condition updated successfully');
    }
}
