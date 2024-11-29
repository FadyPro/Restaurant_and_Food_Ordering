<?php

namespace App\Livewire\Admin;

use App\Models\Blog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.master')]
class AdminDashboard extends Component
{
    use WithPagination;
    public $payment_status,$order_status,$order_id;
    public $isOpen = 0;

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $todaysOrders = Order::whereDate('created_at', now()->format('Y-m-d'))->count();
        $todaysEarnings = Order::whereDate('created_at', now()->format('Y-m-d'))->where('order_status', 'delivered')->sum('grand_total');

        $thisMonthsOrders = Order::whereMonth('created_at', now()->month)->count();
        $thisMonthsEarnings = Order::whereMonth('created_at', now()->month)->where('order_status', 'delivered')->sum('grand_total');

        $thisYearOrders = Order::whereYear('created_at', now()->year)->count();
        $thisYearEarnings = Order::whereYear('created_at', now()->year)->where('order_status', 'delivered')->sum('grand_total');

        $totalOrders = Order::count();
        $totalEarnings = Order::where('order_status', 'delivered')->sum('grand_total');

        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        $totalProducts = Product::count();
        $totalBlogs = Blog::count();

        $model = Order::with(['user'])
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->paginate(10)->withQueryString();

        return view('livewire.admin.admin-dashboard',compact('todaysOrders','todaysEarnings','thisMonthsOrders','thisMonthsEarnings','thisYearOrders',
            'thisYearEarnings','totalOrders','totalEarnings','totalUsers','totalAdmins','totalProducts','totalBlogs','model'));
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
    public function closeModal()
    {
        $this->isOpen = 0;
        $this->reset();
    }

    public function editOrderStatus($id)
    {
        $this->isOpen = true;
        $model = Order::findOrFail($id);
        $this->order_id = $model->id;
        $this->payment_status = $model->payment_status;
        $this->order_status = $model->order_status;

    }
    public function updateOrderStatus()
    {
        $this->validate([
            'payment_status' => ['required', 'in:pending,completed'],
            'order_status' => ['required', 'in:pending,in_process,delivered,declined']
        ]);
        $model = Order::findOrFail($this->order_id);
        $model->payment_status = $this->payment_status;
        $model->order_status = $this->order_status;
        $model->save();
        $this->alertSuccess('Order Status Updated Successfully');
        $this->closeModal();
    }
}
