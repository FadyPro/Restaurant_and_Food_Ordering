<?php

namespace App\Livewire\Admin\AdminManagement;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class AdminManagementEdit extends Component
{
    public $saved = false;
    public $name,$email,$password,$password_confirmation,$role;
    public $user,$model_id;

    public function mount($id)
    {
        $model = User::query()->findOrFail($id);
        $this->user = $model;
        $this->model_id = $id;
        $this->name = $model->name;
        $this->email = $model->email;
        $this->role = $model->role;
    }
    public function render()
    {
        return view('livewire.admin.admin-management.admin-management-edit');
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
        if($this->model_id == 1){
            $this->alertSuccess('you can not update super admin');
            throw ValidationException::withMessages(['you can not update super admin']);
        }

        $this->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$this->model_id],
            'role' => ['required', 'in:admin'],
        ]);

        if($this->password){
            $this->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email,'.$this->model_id],
                'role' => ['required', 'in:admin'],
                'password' => ['confirmed', 'min:5']
            ]);
            $this->user->password = bcrypt($this->password);
        }

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role
        ]);
        $this->saved = true;

        $this->alertSuccess('Successfully Updated');
        return redirect()->to(route('admin.admin-management.index'));
    }
}
