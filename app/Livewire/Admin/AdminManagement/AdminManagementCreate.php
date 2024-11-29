<?php

namespace App\Livewire\Admin\AdminManagement;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class AdminManagementCreate extends Component
{
    public $saved = false;
    public $name,$email,$password,$password_confirmation,$role;

    public function render()
    {
        return view('livewire.admin.admin-management.admin-management-create');
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
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:admin'],
            'password' => ['required', 'confirmed', 'min:5']
        ],[
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'email.unique' => 'Email must be unique',
            'role.required' => 'Role is required',
            'role.in' => 'Role must be admin',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Password must be confirmed',
            'password.min' => 'Password must be at least 8 characters',
        ]);

        $area = new User();
        $area->name = $this->name;
        $area->email = $this->email;
        $area->password = bcrypt($this->password);
        $area->role = $this->role;
        $area->save();

        $this->alertSuccess('Created Successfully');
        return redirect()->to(route('admin.admin-management.index'));
    }
}
