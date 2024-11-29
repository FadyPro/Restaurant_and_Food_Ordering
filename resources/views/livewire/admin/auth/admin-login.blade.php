<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new  #[Layout('layouts.admin.login-admin-master')] class extends Component
{
    public LoginForm $form;

    public function alertSuccess($rel)
    {
        $this->dispatch('alert',
            ['types' => 'success',  'message' => $rel]);
    }
    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if(\Illuminate\Support\Facades\Auth::user()->role === 'admin'){
            $this->redirectIntended(default: RouteServiceProvider::ADMIN, navigate: true);
            $this->alertSuccess('Login Successfully');
        }else if (\Illuminate\Support\Facades\Auth::user()->role === 'user'){
            $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
            $this->alertSuccess('Login Successfully');
        }
    }
};
?>
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
                            <h4>Login</h4>
                        </div>

                        <div class="card-body">
                            <form wire:submit="login" class="needs-validation"
                                  novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input wire:model="form.email" type="email"  id="email" class="form-control"  tabindex="1" required autofocus value="{{ old('email') }}">
                                    @error('form.email') <span class="error">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback">
                                        Please fill in your email
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                        <div class="float-right">
                                            <a href="{{ route('admin.forget-password') }}" class="text-small">
                                                Forgot Password?
                                            </a>
                                        </div>
                                    </div>
                                    <input wire:model="form.password" type="password" id="password" name="password" class="form-control" tabindex="2" required>
                                    @error('form.password') <span class="error">{{ $message }}</span> @enderror
                                    <div class="invalid-feedback">
                                        please fill in your password
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input"
                                               tabindex="3" id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
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

