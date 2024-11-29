<?php

namespace App\Livewire\Admin\Contacts;

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class ContactIndex extends Component
{
    public $phone_one, $phone_two, $mail_one, $mail_two, $address, $map_link;
    public $saved = false;
    public $contact;

    public function mount()
    {
        $model = Contact::findOrFail(1);
        $this->contact = $model;
        $this->phone_one = $model->phone_one;
        $this->phone_two = $model->phone_two;
        $this->mail_one = $model->mail_one;
        $this->mail_two = $model->mail_two;
        $this->address = $model->address;
        $this->map_link = $model->map_link;
    }
    public function render()
    {
        return view('livewire.admin.contacts.contact-index');
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
            'phone_one' => ['nullable', 'max:50'],
            'phone_two' => ['nullable', 'max:50'],
            'mail_one' => ['nullable', 'max:255'],
            'mail_two' => ['nullable', 'max:255'],
            'address' => ['nullable', 'max:1000'],
            'map_link' => ['nullable'],
        ],[
            'phone_one.max' => 'The phone one must not be greater than 50 characters.',
            'phone_two.max' => 'The phone two must not be greater than 50 characters.',
            'mail_one.max' => 'The mail one must not be greater than 255 characters.',
            'mail_two.max' => 'The mail two must not be greater than 255 characters.',
            'address.max' => 'The address must not be greater than 1000 characters.',
            'map_link.max' => 'The map link must not be greater than 255 characters.',
        ]);
        Contact::updateOrCreate(
            ['id' => 1],
            [
                'phone_one' => $this->phone_one,
                'phone_two' => $this->phone_two,
                'mail_one' => $this->mail_one,
                'mail_two' => $this->mail_two,
                'address' => $this->address,
                'map_link' => $this->map_link,
            ]
        );
        $this->alertSuccess('Contact updated successfully');
    }
}
