<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\Setting;
use App\Services\SettingsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class SeoSetting extends Component
{
    public $saved = false;
    public  $key,$value;
    public $seo_title,$seo_description,$seo_keywords;
    public $setting;
    public $model_id;

    public function mount()
    {
        $model = Setting::pluck('value', 'key')->toArray();
        $this->setting = $model;
        $this->seo_title = $model['seo_title'];
        $this->seo_description = $model['seo_description'];
        $this->seo_keywords = $model['seo_keywords'];
    }
    public function render()
    {
        return view('livewire.admin.settings.section.seo-setting');
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
            'seo_title' => ['required', 'max:255'],
            'seo_description' => ['nullable', 'max:600'],
            'seo_keywords' => ['nullable']
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
