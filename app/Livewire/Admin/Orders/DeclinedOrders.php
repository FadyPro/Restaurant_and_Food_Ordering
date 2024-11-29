<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.master')]
class DeclinedOrders extends Component
{
    use WithPagination;

    public $model_id;
    public $payment_status,$order_status,$order_id;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $paginate = 10;
    public $search = "";
    public $sections = null;
    public $selectedSection = null;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    public $isOpen = 0;
    protected $listeners = ['deleteConfirmed'=>'delete'];

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $model = Order::select('orders.*','users.name as user_name','users.phone as user_phone')
            ->WhereHas('user', function ($q) {
                $q->where('name','like','%'.$this->search.'%');
                $q->orWhere('phone','like','%'.$this->search.'%');
            })
            ->orWhere('orders.invoice_id','like','%'.$this->search.'%')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->having('orders.order_status', 'declined')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->paginate)->withQueryString();
        return view('livewire.admin.orders.declined-orders',[
            'model' => $model,
        ]);
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
    public function deleteConfirmation($id)
    {
        $this->model_id = $id;
        $this->dispatch('show-delete-confirm');
    }
    public function delete()
    {
        try{
            $item =  Order::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Image Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('orders.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
    public function deleteOne($id)
    {
        try{
            $item =  Order::findOrFail($id);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('orders.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = Order::pluck('id')->map(fn ($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
        }
//        $this->selectAll = true;
    }
    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }
    public function updatedChecked()
    {
        $this->selectAll = false;
    }
    public function deleteRecords()
    {
        try{
            Order::whereKey($this->checked)->delete();
            $this->checked = [];
            $this->selectAll = false;
            $this->selectPage = false;
            $this->alertSuccess('Selected Records were deleted Successfully');
            //        session()->flash('info', 'Selected Records were deleted Successfully');
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
    public function setSortBy($sortBy)
    {
        if ($this->sortDirection == 'asc')
        {
            $this->sortDirection = 'desc';
        }else{
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $sortBy;
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
