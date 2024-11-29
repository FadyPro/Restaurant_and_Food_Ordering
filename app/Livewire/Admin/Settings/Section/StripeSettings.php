<?php

namespace App\Livewire\Admin\Settings\Section;

use App\Models\PaymentGatewaySetting;
use App\Services\PaymentGatewaySettingService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class StripeSettings extends Component
{
    use WithFileUploads;

    public $saved = false;
    public  $key,$value;
    public $stripe_status,$stripe_country,$stripe_currency,$stripe_rate,$stripe_api_key,$stripe_secret_key,$stripe_image;
    public $stripe;
    public $model_id;


    public function mount()
    {
        $model = PaymentGatewaySetting::pluck('value', 'key')->toArray();
        $this->stripe = $model;
        $this->stripe_status = $model['stripe_status'];
        $this->stripe_country = $model['stripe_country'];
        $this->stripe_currency = $model['stripe_currency'];
        $this->stripe_rate = $model['stripe_rate'];
        $this->stripe_api_key = $model['stripe_api_key'];
        $this->stripe_secret_key = $model['stripe_secret_key'];
    }
    public function render()
    {
        return view('livewire.admin.settings.section.stripe-settings');
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
            'stripe_status' => ['required', 'boolean'],
            'stripe_country' => ['required'],
            'stripe_currency' => ['required'],
            'stripe_rate' => ['required', 'numeric'],
            'stripe_api_key' => ['required'],
            'stripe_secret_key' => ['required'],
        ]);
        if($this->stripe_image){
            $this->validate([
                'stripe_image' => ['nullable', 'image', 'max:3000']
            ]);

            $imagesM = uniqid() . '.' . $this->stripe_image->extension();
            $this->stripe_image->storeAs('uploads', $imagesM,'public_upload');

            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'stripe_image'],
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
