<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.home.master')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
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
                    <h1>sign up</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">sign up</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=========================
        SIGN UP START
    ==========================-->
    <section class="fp__signup" style="background: url({{ asset('frontend/images/login_bg.jpg') }});">
        <div class="fp__signup_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class=" container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="fp__login_area">
                            <h2>Welcome back!</h2>
                            <p>sign up to continue</p>
                            <form wire:submit="register">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>name</label>
                                            <input wire:model="name" type="text" placeholder="Name" name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>email</label>
                                            <input wire:model="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                        </div>
                                    </div>


                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>password</label>
                                            <input wire:model="password" type="password" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <label>confirm password</label>
                                            <input wire:model="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password">
                                        </div>
                                    </div>


                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <button type="submit" class="common_btn">Register</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <p class="or"><span>or</span></p>

                            <p class="create_account"> have an aceount ? <a href="{{ route('login') }}">login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        SIGN UP END
    ==========================-->
</div>
