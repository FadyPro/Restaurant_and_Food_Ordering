<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.admin.login-admin-master')] class extends Component
{
    public string $email = '';


    public function alertSuccess($rel)
    {
        $this->dispatch('alert',
            ['types' => 'success',  'message' => $rel]);
    }
    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));

        $this->alertSuccess('Login Successfully');
    }
}; ?>

<div>
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div
                    class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="assets/img/stisla-fill.svg" alt="logo" width="100"
                             class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Forget Password</h4>
                        </div>

                        <div class="card-body">
                            <form wire:submit="sendPasswordResetLink" class="needs-validation"
                                  novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input wire:model="email" type="email" name="email" class="form-control" tabindex="1" required autofocus value="{{ old('email') }}" >
                                    <div class="invalid-feedback">
                                        Please fill in your email
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Send Reset Link
                                    </button>
                                </div>
                            </form>


                        </div>
                    </div>

                    <div class="simple-footer">
                        Copyright food
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
