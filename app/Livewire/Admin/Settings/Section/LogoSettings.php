<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\Setting;
use App\Services\SettingsService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Cache;
use Livewire\WithFileUploads;
use File;

#[Layout('layouts.admin.master')]
class LogoSettings extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $logo,$footer_logo,$favicon,$breadcrumb;

    public function render()
    {
        $model = Setting::pluck('value', 'key')->toArray();
        return view('livewire.admin.settings.section.logo-settings',compact('model'));
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
    function removeImage(string $path) : void {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
    public function save()
    {
        $validatedData = $this->validate([
            'logo' => ['nullable', 'image', 'max:1000'],
            'footer_logo' => ['nullable', 'image', 'max:1000'],
            'favicon' => ['nullable', 'image', 'max:1000'],
            'breadcrumb' => ['nullable', 'image', 'max:1000'],
        ]);

        if($this->logo){
            $imagesM = uniqid() . '.' . $this->logo->extension();
            $this->logo->storeAs('uploads', $imagesM,'public_upload');

            $oldPath = config('settings.logo');
            $this->removeImage('/uploads/'.$oldPath);

            Setting::updateOrCreate(
                ['key' => 'logo'],
                ['value' => $imagesM]
            );
        }
        if($this->footer_logo){
            $imagesM = uniqid() . '.' . $this->footer_logo->extension();
            $this->footer_logo->storeAs('uploads', $imagesM,'public_upload');

            $oldPath = config('settings.footer_logo');
            $this->removeImage('/uploads/'.$oldPath);

            Setting::updateOrCreate(
                ['key' => 'footer_logo'],
                ['value' => $imagesM]
            );
        }
        if($this->favicon){
            $imagesM = uniqid() . '.' . $this->favicon->extension();
            $this->favicon->storeAs('uploads', $imagesM,'public_upload');

            $oldPath = config('settings.favicon');
            $this->removeImage('/uploads/'.$oldPath);

            Setting::updateOrCreate(
                ['key' => 'favicon'],
                ['value' => $imagesM]
            );
        }
        if($this->breadcrumb){
            $imagesM = uniqid() . '.' . $this->breadcrumb->extension();
            $this->breadcrumb->storeAs('uploads', $imagesM,'public_upload');

            $oldPath = config('settings.breadcrumb');
            $this->removeImage('/uploads/'.$oldPath);

            Setting::updateOrCreate(
                ['key' => 'breadcrumb'],
                ['value' => $imagesM]
            );
        }

        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();
        Cache::forget('mail_settings');

        $this->saved = true;
        $this->alertSuccess('General Settings Successfully Updated');
    }
}
