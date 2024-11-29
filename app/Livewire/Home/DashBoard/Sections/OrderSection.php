<?php

namespace App\Livewire\Home\DashBoard\Sections;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.home.master')]
class OrderSection extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $orders = Order::query()->where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('livewire.home.dash-board.sections.order-section',compact('orders'));
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
}
