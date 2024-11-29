<?php

namespace App\Livewire\Home\DashBoard\Sections;

use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class ReservationSection extends Component
{
    public function render()
    {
        $reservations = Reservation::where('user_id', auth()->user()->id)->get();
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return view('livewire.home.dash-board.sections.reservation-section',compact('reservations','orders'));
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
}
