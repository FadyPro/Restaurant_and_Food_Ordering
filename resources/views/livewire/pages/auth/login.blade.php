<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.home.master')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function alertSuccess($rel)
    {
        $this->dispatch('alert',
            ['types' => 'success',  'message' => $rel]);
    }
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
}; ?>
<div>

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ config('settings.breadcrumb') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>sign in</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">sign in</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="fp__signin" style="background: url(frontend/images/login_bg.jpg);">
        <div class="fp__signin_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="fp__login_area">
                            <h2>Welcome back!</h2>
                            <p>sign in to continue</p>
                            <form wire:submit="login">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>email</label>
                                            <input wire:model="form.email" type="email"  id="email"  placeholder="Email" required value="{{ old('email') }}">
                                            @error('form.email') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>password</label>
                                            <input wire:model="form.password" type="password" id="password" name="password" placeholder="Password" >
                                            @error('form.password') <span class="error">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="fp__login_imput fp__login_check_area">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault" name="remember">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Remeber Me
                                                </label>
                                            </div>
                                            @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" wire:navigate style="color: #fba35e">Forgot Password ?</a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <button type="submit" class="common_btn">login</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="or"><span>or</span></p>

                            <p class="create_account">Dont’t have an aceount ? <a  href="{{ route('register') }}">Create Account</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        SIGNIN END
    ==========================-->
    </div>
