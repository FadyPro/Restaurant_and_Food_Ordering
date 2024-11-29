<?php

namespace App\Livewire\Admin\Coupon;

use App\Models\Coupon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class CouponCreate extends Component
{
    public $saved = false;
    public $name,$code,$quantity,$min_purchase_amount,$expire_date,$discount_type,$discount,$status;

    public function render()
    {
        return view('livewire.admin.coupon.coupon-create');
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
            'name' => 'required|max:255',
            'code' => 'required|max:50',
            'quantity' => 'required|integer',
            'min_purchase_amount' => 'required|integer',
            'expire_date' => 'required|date',
            'discount_type' => 'required',
            'discount' => 'required',
            'status' => 'required|boolean'
        ], [
            'name.required' => 'Name Required ',
            'code.required' => 'code Required',
            'status.required' => 'status Required',
            'quantity.required' => 'quantity Required',
            'min_purchase_amount.required' => 'min purchase amount Required ',
            'expire_date.required' => 'expire date Required',
            'discount_type.required' => 'discount type Required',
            'discount.required' => 'discount Required',
        ]);

        $coupon = new Coupon();
        $coupon->name = $this->name;
        $coupon->code = $this->code;
        $coupon->quantity = $this->quantity;
        $coupon->min_purchase_amount = $this->min_purchase_amount;
        $coupon->expire_date = $this->expire_date;
        $coupon->discount_type = $this->discount_type;
        $coupon->discount = $this->discount;
        $coupon->status = $this->status;
        $coupon->save();

        $this->alertSuccess('Coupon inserted Successfully');
        return redirect()->to(route('admin.coupon.index'));
    }
}
