<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class MailSettings extends Component
{
    public $saved = false;
    public $mail_driver,$mail_host,$mail_port,$mail_username,$mail_password,$mail_encryption,$mail_from_address,$mail_receive_address;
    public $setting;
    public $model_id;

    public function mount()
    {
        $model = Setting::pluck('value', 'key')->toArray();
        $this->setting = $model;
        $this->mail_driver = $model['mail_driver'];
        $this->mail_host = $model['mail_host'];
        $this->mail_port = $model['mail_port'];
        $this->mail_username = $model['mail_username'];
        $this->mail_password = $model['mail_password'];
        $this->mail_encryption = $model['mail_encryption'];
        $this->mail_from_address = $model['mail_from_address'];
        $this->mail_receive_address = $model['mail_receive_address'];
    }
    public function render()
    {
        return view('livewire.admin.settings.section.mail-settings');
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
        $validatedData = $this->validate([
            'mail_driver' => ['required'],
            'mail_host' => ['required'],
            'mail_port' => ['required'],
            'mail_username' => ['required'],
            'mail_password' => ['required'],
            'mail_encryption' => ['required'],
            'mail_from_address' => ['required'],
            'mail_receive_address' => ['required'],
        ]);

        foreach($validatedData as $key => $value){
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings');

        $this->saved = true;
        $this->alertSuccess('General Settings Successfully Updated');
    }
}
