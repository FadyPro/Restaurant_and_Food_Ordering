<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\PaymentGatewaySetting;
use App\Services\PaymentGatewaySettingService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class PayPalSettings extends Component
{
    use WithFileUploads;

    public $saved = false;
    public  $key,$value;
    public $paypal_status,$paypal_country,$paypal_currency,$paypal_rate,$paypal_api_key,$paypal_secret_key,$paypal_app_id,$paypal_image;
    public $paypal;
    public $model_id;

    public function mount()
    {
        $model = PaymentGatewaySetting::pluck('value', 'key')->toArray();
        $this->paypal = $model;
        $this->paypal_status = $model['paypal_status'];
        $this->paypal_country = $model['paypal_country'];
        $this->paypal_currency = $model['paypal_currency'];
        $this->paypal_rate = $model['paypal_rate'];
        $this->paypal_api_key = $model['paypal_api_key'];
        $this->paypal_secret_key = $model['paypal_secret_key'];
        $this->paypal_app_id = $model['paypal_app_id'];
    }

    public function render()
    {
        return view('livewire.admin.settings.section.pay-pal-settings');
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
            'paypal_status' => ['required', 'boolean'],
            'paypal_country' => ['required'],
            'paypal_currency' => ['required'],
            'paypal_rate' => ['required', 'numeric'],
            'paypal_api_key' => ['required'],
            'paypal_secret_key' => ['required'],
            'paypal_app_id' => ['required'],
        ]);
        if($this->paypal_image){
            $this->validate([
                'paypal_image' => ['nullable', 'image', 'max:3000']
            ]);

            $imagesM = uniqid() . '.' . $this->paypal_image->extension();
            $this->paypal_image->storeAs('uploads', $imagesM,'public_upload');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'paypal_image'],
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
