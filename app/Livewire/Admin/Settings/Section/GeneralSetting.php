<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\Setting;
use App\Services\SettingsService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class GeneralSetting extends Component
{
    use WithFileUploads;

    public $saved = false;
    public  $key,$value;
    public $site_name,$site_email,$site_phone,$site_default_currency,$site_currency_icon,$site_currency_icon_position;
    public $setting;
    public $model_id;

    public function mount()
    {
        $model = Setting::pluck('value', 'key')->toArray();
        $this->setting = $model;
        $this->site_name = $model['site_name'];
        $this->site_email = $model['site_email'];
        $this->site_phone = $model['site_phone'];
        $this->site_default_currency = $model['site_default_currency'];
        $this->site_currency_icon = $model['site_currency_icon'];
        $this->site_currency_icon_position = $model['site_currency_icon_position'];
    }
    public function render()
    {
        return view('livewire.admin.settings.section.general-setting');
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
            'site_name' => ['required', 'max:255'],
            'site_email' => ['nullable', 'max:255'],
            'site_phone' => ['nullable', 'max:255'],
            'site_default_currency' => ['required', 'max:4'],
            'site_currency_icon' => ['required', 'max:4'],
            'site_currency_icon_position' => ['required', 'max:255'],
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
        $this->alertSuccess('General Settings Successfully Updated');
    }
}
