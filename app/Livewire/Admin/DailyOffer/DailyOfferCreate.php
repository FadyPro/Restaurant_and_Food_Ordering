<?php

namespace App\Livewire\Admin\DailyOffer;

use App\Models\DailyOffer;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class DailyOfferCreate extends Component
{
    public $saved = false;
    public $product_id,$status;
    public function render()
    {
        $products = Product::all();
        return view('livewire.admin.daily-offer.daily-offer-create',compact('products'));
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

        $area = new DailyOffer();
        $area->product_id = $this->product_id;
        $area->status = $this->status;
        $area->save();

        $this->alertSuccess('Created Successfully');
        return redirect()->to(route('admin.daily-offer.index'));
    }
}
