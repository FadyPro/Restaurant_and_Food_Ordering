<div>
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
                                    <a class="nav-link active" href="{{route('admin.setting.pusher-setting')}}">Pusher Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.setting.logo-setting')}}">Logo Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.setting.appearance-setting')}}">Appearance Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.setting.mail-setting')}}">Mail Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.setting.seo-setting')}}">Seo Settings</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-pane fade show" id="pusher-setting" role="tabpanel" aria-labelledby="home-tab4">
                                    <div class="card">
                                        <div class="card-body border">
                                            <form wire:submit.prevent="save">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="">Pusher App Id</label>
                                                    <input wire:model="pusher_app_id" name="pusher_app_id" type="text" class="form-control">
                                                    @error('pusher_app_id') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Pusher Key</label>
                                                    <input wire:model="pusher_key" name="pusher_key" type="text" class="form-control">
                                                    @error('pusher_key') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Pusher Secret</label>
                                                    <input wire:model="pusher_secret" name="pusher_secret" type="text" class="form-control">
                                                    @error('pusher_secret') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Pusher cluster</label>
                                                    <input wire:model="pusher_cluster" name="pusher_cluster" type="text" class="form-control">
                                                    @error('pusher_cluster') <span class="error">{{ $message }}</span> @enderror
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
        </section>
    </div>
    @script()
    <script>
        // select2
        $(document).ready(function() {
            $('#paypal_status').select2();
            $('#paypal_status').on('change',function (){
                let data = $(this).val()
                console.log(data)
                $wire.set('paypal_status',data)
            });
        });
        // // select2
        $(document).ready(function() {
            $('#paypal_country').select2();
            $('#paypal_country').on('change',function (){
                let data = $(this).val()
                console.log(data)
                $wire.set('paypal_country',data)
            });
        });
        // select2
        $(document).ready(function() {
            $('#paypal_currency').select2();
            $('#paypal_currency').on('change',function (){
                let data = $(this).val()
                console.log(data)
                $wire.set('paypal_currency',data)
            });
        });
    </script>
    @endscript


</div>
