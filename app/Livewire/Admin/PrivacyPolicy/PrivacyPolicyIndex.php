<?php

namespace App\Livewire\Admin\PrivacyPolicy;

use App\Models\PrivacyPolicy;
use App\Models\TramsAndCondition;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class PrivacyPolicyIndex extends Component
{
    public $saved = false;
    public $content;
    public $terms;

    public function mount()
    {
        $model = PrivacyPolicy::findOrFail(1);
        $this->terms = $model;
        $this->content = $model->content;
    }
    public function render()
    {
        return view('livewire.admin.privacy-policy.privacy-policy-index');
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
        PrivacyPolicy::updateOrCreate(
            ['id' => 1],
            [
                'content' => $this->content,
            ]
        );
        $this->alertSuccess('Privacy policy updated successfully');
    }
}
