<?php

namespace App\Livewire\Admin\Coupon;

use App\Models\Coupon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class CouponEdit extends Component
{

    public $saved = false;
    public $name,$code,$quantity,$min_purchase_amount,$expire_date,$discount_type,$discount,$status;
    public $model_id;
    public $coupon;


    public function mount($id)
    {
        $model = Coupon::query()->findOrFail($id);
         $this->coupon = $model;
         $this->name = $model->name;
         $this->code = $model->code;
         $this->quantity = $model->quantity;
         $this->min_purchase_amount = $model->min_purchase_amount;
         $this->expire_date = $model->expire_date;
         $this->discount_type = $model->discount_type;
         $this->discount = $model->discount;
         $this->status = $model->status;
         $this->model_id = $model->id;
    }
    public function render()
    {
        return view('livewire.admin.coupon.coupon-edit');
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
            'name' => ['required', 'max:255'],
            'code' => ['required', 'max:50'],
            'quantity' => ['required', 'integer'],
            'min_purchase_amount' => ['required', 'integer'],
            'expire_date' => ['required', 'date'],
            'discount_type' => ['required'],
            'discount' => ['required'],
            'status' => ['required', 'boolean']
        ],[
            'name.required' => 'Name Required ',
            'code.required' => 'code Required',
            'status.required' => 'status Required',
            'quantity.required' => 'quantity Required',
            'min_purchase_amount.required' => 'min purchase amount Required ',
            'expire_date.required' => 'expire date Required',
            'discount_type.required' => 'discount type Required',
            'discount.required' => 'discount Required',
        ]);
        $this->coupon->update([
            'name' => $this->name,
            'code' => $this->code,
            'quantity' => $this->quantity,
            'min_purchase_amount' => $this->min_purchase_amount,
            'expire_date' => $this->expire_date,
            'discount_type' => $this->discount_type,
            'discount' => $this->discount,
            'status' => $this->status,
        ]);
        $this->saved = true;

        $this->alertSuccess('Coupon Successfully Updated');
        return redirect()->to(route('admin.coupon.index'));
    }
}
