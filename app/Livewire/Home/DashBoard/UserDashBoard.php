<?php

namespace App\Livewire\Home\DashBoard;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

#[Layout('layouts.home.master')]
class UserDashBoard extends Component
{
    public function render()
    {
        $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        $totalCompleteOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'delivered')->count();
        $totalCancelOrders = Order::where('user_id', auth()->user()->id)->where('order_status', 'declined')->count();
        return view('livewire.home.dash-board.user-dash-board',compact('totalOrders','totalCompleteOrders','totalCancelOrders'));
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
}
