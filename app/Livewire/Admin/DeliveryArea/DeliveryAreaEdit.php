<?php

namespace App\Livewire\Admin\DeliveryArea;

use App\Models\DeliveryArea;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class DeliveryAreaEdit extends Component
{
    public $saved = false;
    public $area_name,$min_delivery_time,$max_delivery_time,$delivery_fee,$status;
    public $model_id;
    public $DeliveryArea;

    public function mount($id)
    {
        $model = DeliveryArea::query()->findOrFail($id);
        $this->DeliveryArea = $model;
        $this->model_id = $id;
        $this->area_name = $model->area_name;
        $this->min_delivery_time = $model->min_delivery_time;
        $this->max_delivery_time = $model->max_delivery_time;
        $this->delivery_fee = $model->delivery_fee;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.delivery-area.delivery-area-edit');
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
            'area_name' => ['required', 'max:255'],
            'min_delivery_time' => ['required', 'max:255'],
            'max_delivery_time' => ['required', 'max:255'],
            'delivery_fee' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ],[
            'area_name.required' => 'Area Name Required',
            'min_delivery_time.required' => 'Min Delivery Time Required',
            'max_delivery_time.required' => 'Max Delivery Time Required',
            'delivery_fee.required' => 'Delivery Fee Required',
            'status.required' => 'Status Required',
        ]);

        $this->DeliveryArea->update([
            'area_name' => $this->area_name,
            'min_delivery_time' => $this->min_delivery_time,
            'max_delivery_time' => $this->max_delivery_time,
            'delivery_fee' => $this->delivery_fee,
            'status' => $this->status,
        ]);
        $this->saved = true;

        $this->alertSuccess('Successfully Updated');
        return redirect()->to(route('admin.delivery-area.index'));
    }
}
