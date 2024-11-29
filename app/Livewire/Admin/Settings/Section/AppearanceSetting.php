<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\Setting;
use App\Services\SettingsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class AppearanceSetting extends Component
{
    public $saved = false;
    public  $key,$value;
    public $site_color;
    public $setting;
    public $model_id;

    public function mount()
    {
        $model = Setting::pluck('value', 'key')->toArray();
        $this->setting = $model;
        $this->site_color = $model['site_color'];
    }
    public function render()
    {
        return view('livewire.admin.settings.section.appearance-setting');
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
            'site_color' => ['required']
        ]);
        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        $this->saved = true;
        $this->alertSuccess('Settings Successfully Updated');
    }
}
