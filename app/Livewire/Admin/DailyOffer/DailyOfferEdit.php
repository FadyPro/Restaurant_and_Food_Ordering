<?php

namespace App\Livewire\Admin\DailyOffer;

use App\Models\DailyOffer;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class DailyOfferEdit extends Component
{
    public $saved = false;
    public $product_id,$status;
    public $dailyOffer,$model_id;

    public function mount($id)
    {
        $model = DailyOffer::query()->findOrFail($id);
        $this->dailyOffer = $model;
        $this->model_id = $id;
        $this->product_id = $model->product_id;
        $this->status = $model->status;
    }
    public function render()
    {
        $products = Product::all();
        return view('livewire.admin.daily-offer.daily-offer-edit',compact('products'));
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
            'product_id' => ['required', 'exists:products,id'],
            'status' => ['required', 'boolean'],
        ],[
            'product_id.required' => 'Product Required',
            'status.required' => 'Status Required',
        ]);

        $this->dailyOffer->update([
            'product_id' => $this->product_id,
            'status' => $this->status
        ]);
        $this->saved = true;

        $this->alertSuccess('Successfully Updated');
        return redirect()->to(route('admin.daily-offer.index'));
    }
}
