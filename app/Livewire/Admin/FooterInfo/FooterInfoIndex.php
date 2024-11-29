<?php

namespace App\Livewire\Admin\FooterInfo;

use App\Models\FooterInfo;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class FooterInfoIndex extends Component
{
    public $saved = false;
    public $short_info,$address,$phone,$email,$copyright;
    public $footerInfo,$model_id;

    public function mount()
    {
        $model = FooterInfo::query()->findOrFail(1);
        $this->footerInfo = $model;
        $this->short_info = $model->short_info;
        $this->address = $model->address;
        $this->phone = $model->phone;
        $this->email = $model->email;
        $this->copyright = $model->copyright;
    }
    public function render()
    {
        return view('livewire.admin.footer-info.footer-info-index');
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
            'short_info' => ['nullable', 'max:2000'],
            'address' => ['nullable', 'max:255'],
            'phone' =>['nullable', 'max:255'],
            'email' =>['nullable', 'max:255'],
            'copyright' =>['nullable', 'max:255']
        ],[
            'short_info.max' => 'Short Info Max 2000 Character',
            'address.max' => 'Address Max 255 Character',
            'phone.max' => 'Phone Max 255 Character',
            'email.max' => 'Email Max 255 Character',
            'copyright.max' => 'Copyright Max 255 Character',
        ]);
        FooterInfo::updateOrCreate(
            ['id' => 1],
            [
                'short_info' => $this->short_info,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'copyright' => $this->copyright
            ]
        );
        $this->saved = true;

        $this->alertSuccess('Footer Info Successfully Updated');
        return redirect()->to(route('admin.footer-info.index'));
    }
}
