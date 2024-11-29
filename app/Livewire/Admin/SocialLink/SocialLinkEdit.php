<?php

namespace App\Livewire\Admin\SocialLink;

use App\Models\SocialLink;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class SocialLinkEdit extends Component
{
    public $saved = false;
    public $icon,$name,$link,$status;
    public $socialLink;
    public $model_id;

    public function mount($id)
    {
        $model = SocialLink::query()->findOrFail($id);
        $this->socialLink = $model;
        $this->model_id = $id;
        $this->icon = $model->icon;
        $this->name = $model->name;
        $this->link = $model->link;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.social-link.social-link-edit');
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
            'icon' => ['required'],
            'name' => ['required'],
            'link' => ['required',],
            'status' => ['required', 'boolean']
        ],[
            'icon.required' => 'Icon is required',
            'name.required' => 'Name is required',
            'link.required' => 'Link is required',
            'status.required' => 'Status is required',
        ]);

        $this->socialLink->update([
            'icon' => $this->icon,
            'name' => $this->name,
            'link' => $this->link,
            'status' => $this->status
        ]);
        $this->saved = true;

        $this->alertSuccess('Social Link Successfully Updated');
        return redirect()->to(route('admin.social-link.index'));
    }
}
