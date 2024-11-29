<div>
    <section class="section">
        <div class="section-header">
            <h1>Settings</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Settings</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2">
                        <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link"  href="{{route('admin.setting.general-setting')}}">General Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.paypal-setting')}}">PayPal</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.stripe-setting')}}">Stripe</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  href="{{route('admin.setting.paymob-setting')}}">PayMob</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.pusher-setting')}}">Pusher Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.logo-setting')}}">Logo Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.appearance-setting')}}">Appearance Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{route('admin.setting.mail-setting')}}">Mail Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.seo-setting')}}">Seo Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                        <div class="tab-content no-padding">
                            <div class="tab-pane fade show active">
                                <div class="card">
                                    <div class="card-body border">
                                        <form wire:submit.prevent="save">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Mail Driver</label>
                                                        <input wire:model="mail_driver" name="mail_driver" type="text" class="form-control">
                                                        @error('mail_driver') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Mail Host</label>
                                                        <input wire:model="mail_host" name="mail_host" type="text" class="form-control">
                                                        @error('mail_host') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Mail Port</label>
                                                        <input wire:model="mail_port" name="mail_port" type="text" class="form-control">
                                                        @error('mail_port') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Mail Username</label>
                                                        <input wire:model="mail_username" name="mail_username" type="text" class="form-control">
                                                        @error('mail_username') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Mail Password</label>
                                                        <input wire:model="mail_password" name="mail_password" type="text" class="form-control">
                                                        @error('mail_password') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Mail Encryption</label>
                                                <input wire:model="mail_encryption" name="mail_encryption" type="text" class="form-control">
                                                @error('mail_encryption') <span class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="">Mail Form Address</label>
                                                <input wire:model="mail_from_address" name="mail_from_address" type="text" class="form-control">
                                                @error('mail_from_address') <span class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="">Mail Receive Address</label>
                                                <input wire:model="mail_receive_address" name="mail_receive_address" type="text" class="form-control">
                                                @error('mail_receive_address') <span class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

