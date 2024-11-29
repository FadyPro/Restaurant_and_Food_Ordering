<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\PaymentGatewaySetting;
use App\Services\PaymentGatewaySettingService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class PaymobSettings extends Component
{
    use WithFileUploads;

    public $saved = false;
    public  $key,$value;
    public $paymob_status,$paymob_country,$paymob_currency,$paymob_rate,$paymob_api_key,$paymob_secret_key,$paymob_public_key,$paymob_integration_id,$paymob_iframe_id,$paymob_hmac,
        $paymob_image;
    public $paymob;
    public $model_id;

    public function mount()
    {
        $model = PaymentGatewaySetting::pluck('value', 'key')->toArray();
        $this->paymob = $model;
        $this->paymob_status = $model['paymob_status'];
        $this->paymob_country = $model['paymob_country'];
        $this->paymob_currency = $model['paymob_currency'];
        $this->paymob_rate = $model['paymob_rate'];
        $this->paymob_api_key = $model['paymob_api_key'];
        $this->paymob_integration_id = $model['paymob_integration_id'];
        $this->paymob_iframe_id = $model['paymob_iframe_id'];
        $this->paymob_hmac = $model['paymob_hmac'];
        $this->paymob_secret_key = $model['paymob_secret_key'];
        $this->paymob_public_key = $model['paymob_public_key'];
    }
    public function render()
    {
        return view('livewire.admin.settings.section.paymob-settings');
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
            'paymob_status' => ['required', 'boolean'],
            'paymob_country' => ['required'],
            'paymob_currency' => ['required'],
            'paymob_rate' => ['required', 'numeric'],
            'paymob_api_key' => ['required'],
            'paymob_integration_id' => ['required', 'numeric'],
            'paymob_iframe_id' => ['required'],
            'paymob_hmac' => ['required'],
            'paymob_secret_key' => ['required'],
            'paymob_public_key' => ['required'],
        ]);
        if($this->paymob_image){
            $this->validate([
                'paymob_image' => ['nullable', 'image', 'max:3000']
            ]);

            $imagesM = uniqid() . '.' . $this->paymob_image->extension();
            $this->paymob_image->storeAs('uploads', $imagesM,'public_upload');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'paymob_image'],
                ['value' => $imagesM]
            );
        }
        foreach($validatedData as $key => $value){
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settingsService = app(PaymentGatewaySettingService::class);
        $settingsService->clearCachedSettings();

        $this->saved = true;
        $this->alertSuccess('General Settings Successfully Updated');
    }
}
