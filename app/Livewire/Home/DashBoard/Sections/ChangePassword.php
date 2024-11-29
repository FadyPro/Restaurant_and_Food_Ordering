<?php

namespace App\Livewire\Home\DashBoard\Sections;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class ChangePassword extends Component
{
    public $current_password,$password,$password_confirmation;

    public function render()
    {
        $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        $totalCompleteOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'delivered')->count();
        $totalCancelOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'declined')->count();
        return view('livewire.home.dash-board.sections.change-password',compact('totalOrders','totalCompleteOrders','totalCancelOrders'));
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
    public function updatePassword()
    {
        $this->validate([
            'current_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Current Password Not Correct');
                        $this->alertDelete('Current Password Not Correct');
                    }
                },
            ],
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|same:password'
        ],[
//            'current_password.required' => 'Current Password required.',
//            'password.required' => 'password required.',
//            'password_confirmation.required' => 'password confirmation required.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);
        $this->saved = true;
        $this->alertSuccess('Password successfully updated');
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
}
