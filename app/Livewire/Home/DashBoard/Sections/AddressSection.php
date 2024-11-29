<?php

namespace App\Livewire\Home\DashBoard\Sections;

use App\Models\Address;
use App\Models\DeliveryArea;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class AddressSection extends Component
{
    public $user_id,$delivery_area_id,$first_name,$last_name,$email,$phone,$address,$type;
    public $isOpen = 0;
    public $address_id;

    public function render()
    {
        $userAddresses = Address::query()->where('user_id',Auth::user()->id)->get();
        $deliveryAreas = DeliveryArea::all();
        $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        $totalCompleteOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'delivered')->count();
        $totalCancelOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'declined')->count();
        return view('livewire.home.dash-board.sections.address-section',compact('userAddresses','deliveryAreas','totalOrders','totalCompleteOrders','totalCancelOrders'));
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
    public function closeModal()
    {
        $this->isOpen = 0;
        $this->reset();
    }
    public function edit($id)
    {
        $this->isOpen = true;
        $address = Address::findOrFail($id);
        $this->address_id = $address->id;
        $this->user_id = $address->user_id;
        $this->delivery_area_id = $address->delivery_area_id;
        $this->first_name = $address->first_name;
        $this->last_name = $address->last_name;
        $this->phone = $address->phone;
        $this->email = $address->email;
        $this->address = $address->address;
        $this->type = $address->type;
    }
    public function update()
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
        $address = Address::findOrFail($this->address_id);
        $address->delivery_area_id = $this->delivery_area_id;
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->email = $this->email;
        $address->address = $this->address;
        $address->type = $this->type;
        $address->save();
        $this->alertSuccess('Updated Successfully');
        $this->reset();
        $this->isOpen = 0;
//        return redirect()->to(route('address-section'));
    }
    public function deleteOne($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
        $this->alertSuccess('Deleted Successfully');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
}
