<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\Setting;
use App\Services\SettingsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class PusherSettings extends Component
{
    public $saved = false;
    public  $key,$value;
    public $pusher_app_id,$pusher_key,$pusher_secret,$pusher_cluster;
    public $pusher;

    public function mount()
    {
        $model = Setting::pluck('value', 'key')->toArray();
        $this->pusher = $model;
        $this->pusher_app_id = $model['pusher_app_id'];
        $this->pusher_key = $model['pusher_key'];
        $this->pusher_secret = $model['pusher_secret'];
        $this->pusher_cluster = $model['pusher_cluster'];
    }
    public function render()
    {
        return view('livewire.admin.settings.section.pusher-settings');
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
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required'],
        ]);
        foreach($validatedData as $key => $value){
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        $this->saved = true;
        $this->alertSuccess('General Settings Successfully Updated');
    }
}
