<?php

namespace App\Livewire\Admin\SocialLink;

use App\Models\SocialLink;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class SocialLinkCreate extends Component
{
    public $saved = false;
    public $icon,$name,$link,$status;

    public function render()
    {
        return view('livewire.admin.social-link.social-link-create');
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

        $area = new SocialLink();
        $area->icon = $this->icon;
        $area->name = $this->name;
        $area->link = $this->link;
        $area->status = $this->status;
        $area->save();

        $this->alertSuccess('Social Link Created Successfully');
        return redirect()->to(route('admin.social-link.index'));
    }
}
