<?php

namespace App\Livewire\Admin\ReservationTime;

use App\Models\ReservationTime;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class ReservationTimeEdit extends Component
{
    public $start_time,$end_time,$status;
    public $resTime,$model_id;

    public function mount($id)
    {
        $model = ReservationTime::findOrFail($id);
        $this->model_id = $model->id;
        $this->resTime = $model;
        $this->start_time = $model->start_time;
        $this->end_time = $model->end_time;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.reservation-time.reservation-time-edit');
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
            'start_time' => ['required'],
            'end_time' => ['required'],
            'status' => ['required', 'boolean']
        ]);

        $this->resTime->update([
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status
        ]);
        $this->alertSuccess('Reservation Time Updated Successfully');
        return redirect()->route('admin.reservation-time.index');
    }
}
