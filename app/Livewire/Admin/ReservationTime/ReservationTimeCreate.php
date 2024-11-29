<?php

namespace App\Livewire\Admin\ReservationTime;

use App\Models\ReservationTime;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class ReservationTimeCreate extends Component
{
    public $start_time,$end_time,$status;

    public function render()
    {
        return view('livewire.admin.reservation-time.reservation-time-create');
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

        $model = new ReservationTime();
        $model->start_time = $this->start_time;
        $model->end_time = $this->end_time;
        $model->status = $this->status;
        $model->save();
        $this->alertSuccess('Reservation Time Created Successfully');
        return redirect()->route('admin.reservation-time.index');
    }

}
