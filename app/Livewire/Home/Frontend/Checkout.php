<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class Checkout extends Component
{
    public $user_id,$delivery_area_id,$first_name,$last_name,$email,$phone,$address,$type;
    public $isOpen = 0;
    public $address_id;
    public $total = 0;
    public $deliveryFee = 0;


    public function mount()
    {
        $this->grandCartTotal();
    }

    public function render()
    {
        $addresses = Address::where(['user_id' => auth()->user()->id])->get();
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        return view('livewire.home.frontend.checkout', compact('addresses', 'deliveryAreas'));
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
    public function addAddress()
    {
        $this->validate([
            'delivery_area_id' => ['required', 'integer'],
            'first_name' => ['required', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required'],
            'type' => ['required', 'in:home,office']
        ],[
            'delivery_area_id.required' => 'Area Required',
            'first_name.required' => 'First Name Required',
            'last_name.required' => 'Last Name Required',
            'phone.required' => 'Phone Required',
            'email.required' => 'Email Required',
            'address.required' => 'Address Required',
            'type.required' => 'Type Required',
        ]);

        $area = new Address();
        $area->user_id = Auth::user()->id;
        $area->delivery_area_id = $this->delivery_area_id;
        $area->first_name = $this->first_name;
        $area->last_name = $this->last_name;
        $area->phone = $this->phone;
        $area->email = $this->email;
        $area->address = $this->address;
        $area->type = $this->type;
        $area->save();

        $this->alertSuccess('Created Successfully');
        return redirect()->to(route('address-section'));
    }
    function grandCartTotal($deliveryFee = 0)
    {
        $total = 0;
        $cartTotal = cartTotal();
        if (session()->has('coupon')) {
            $discount = session()->get('coupon')['discount'];
            $total = ($cartTotal + $deliveryFee) - $discount;
            $this->total = $total;
//            return $total;
        } else {
            $total = $cartTotal + $deliveryFee;
            $this->total = $total;
//            return $total;
        }
    }
    function CalculateDeliveryCharge() {
        try {
            $address = Address::findOrFail($this->address_id);
            $deliveryFee = $address->deliveryArea?->delivery_fee;
            $grandTotal = $this->grandCartTotal($deliveryFee);

            $this->deliveryFee = $deliveryFee;

            return response(['delivery_fee' => $deliveryFee, 'grand_total' => $grandTotal]);
        }catch(\Exception $e) {
            logger($e);
            $this->alertDelete('some thing went wrong');
//            return response(['message' => 'Something Went Wrong!'], 422);
        }
    }

    function checkoutRedirect()  {
        $this->validate([
            'address_id' => ['required', 'integer']
        ]);

        $address = Address::with('deliveryArea')->findOrFail($this->address_id);

        $selectedAddress = $address->address.', Aria: '. $address->deliveryArea?->area_name;

        session()->put('address', $selectedAddress);
        session()->put('delivery_fee', $address->deliveryArea->delivery_fee);
        session()->put('address_id', $this->address_id);

        return redirect()->to(route('payment.index'));
//        return response(['redirect_url' => route('payment.index')]);
    }

    public function closeModal()
    {
        $this->isOpen = 0;
        $this->reset();
    }
    public function openModal()
    {
        $this->isOpen = 1;
    }
}
