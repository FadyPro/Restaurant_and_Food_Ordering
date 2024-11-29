<?php

namespace App\Livewire\Home\Frontend;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class ContactPage extends Component
{
    public $name, $email, $subject, $message;

    public function render()
    {
        $contact = Contact::findOrFail(1);
        return view('livewire.home.frontend.contact-page',compact('contact'));
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
    function sendContactMessage()
    {
        $this->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max: 1000']
        ]);

        Mail::send(new ContactMail($this->name, $this->email, $this->subject, $this->message));
        $this->reset();
        $this->alertSuccess('Message Sent Successfully!');
        return response(['status' => 'success', 'message' => 'Message Sent Successfully!']);
    }
}
