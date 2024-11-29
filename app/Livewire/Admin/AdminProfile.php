<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class AdminProfile extends Component
{
    use WithFileUploads;
    public $saved = false;
    public string $name = '';
    public string $email = '';
    public $phone = '';
    public $address = '';
    public $current_password,$password,$password_confirmation;
    public $avatar;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
        $this->address = Auth::user()->address;
    }
    public function render()
    {
        return view('livewire.admin.admin-profile');
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
    public function updatedPhoto()
    {
        $this->validate([
            'avatar' => 'image|max:10'
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'max:255',
            'email' => 'max:255|email',
            'phone' => 'max:255',
            'address' => 'max:255',
            'avatar' => 'nullable|image|max:20|mimes:jpeg,jpg,png,gif',
        ]);

        if($this->avatar){
            @unlink(public_path('uploads/avatars/'.Auth::user()->avatar));
            $imageName = uniqid() . '-' . time() . '.' . $this->avatar->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->avatar);
            $image->resize(300,300)->toJpeg()->save(public_path('\uploads\avatars/'.$imageName));
//            $this->avatar->storeAs('uploads/admin_image', $imageName,'public_upload');
        }
        if ($this->avatar)
        {
            Auth::user()->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'avatar' => ($this->avatar ? $imageName: Auth::user()->avatar)
            ]);
        }else{
            Auth::user()->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);
        }

        $this->saved = true;
        $this->alertSuccess('Profile Successfully Updated');
    }
    public function updatePassword()
    {
        $this->validate([
            'current_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Current Password Not Correct');
                        $this->alertDelete('Current Password Not Correct');
                    }
                },
            ],
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|same:password'
        ],[
//            'current_password.required' => 'Current Password required.',
//            'password.required' => 'password required.',
//            'password_confirmation.required' => 'password confirmation required.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);
        $this->saved = true;
        $this->alertSuccess('Password successfully updated');
    }
}
