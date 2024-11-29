<?php

namespace App\Livewire\Admin\Reservation;

use App\Models\Reservation;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class ReservationIndex extends Component
{
    public $model_id,$reservation_id;
    public $paginate = 10;
    public $search = "";
    public $sections = null;
    public $selectedSection = null;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    public $status;
    public $isOpen = 0;
    protected $listeners = ['deleteConfirmed'=>'delete'];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $model = Reservation::with(['user'])
            ->where('reservation_id', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->paginate)->withQueryString();
        return view('livewire.admin.reservation.reservation-index',compact('model'));
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
            $item =  Reservation::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Coupon Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.reservation.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }

    public function deleteOne($id)
    {
        try{
            $item =  Reservation::findOrFail($id);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.reservation.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = Reservation::pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
            Reservation::whereKey($this->checked)->delete();
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
    public function closeModal()
    {
        $this->isOpen = 0;
        $this->reset();
    }
    public function editStatus($id)
    {
        $this->isOpen = true;
        $model =  Reservation::findOrFail($id);
        $this->reservation_id = $model->id;
        $this->status = $model->status;
    }
    public function updateStatus()
    {
        try{
            $model =  Reservation::findOrFail($this->reservation_id);
            $model->status = $this->status;
            $model->save();
            $this->alertSuccess('Status Updated Successfully');
            $this->closeModal();
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
        }
    }
}
