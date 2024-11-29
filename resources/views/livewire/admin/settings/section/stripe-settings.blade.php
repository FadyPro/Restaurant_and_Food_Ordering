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
                                <a class="nav-link active" href="{{route('admin.setting.stripe-setting')}}">Stripe</a>
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
                                <a class="nav-link" href="{{route('admin.setting.mail-setting')}}">Mail Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.seo-setting')}}">Seo Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                        <div class="tab-content no-padding" id="myTab2Content">
                            <div class="tab-pane fade show active" id="stripe-setting" role="tabpanel" aria-labelledby="home-tab4">
                                <div class="card">
                                    <div class="card-body border">
                                        <form wire:submit.prevent="save">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Stripe Status</label>
                                                <select wire:model="stripe_status" name="stripe_status" id="stripe_status" class="select2 form-control">
                                                    <option selected="">Choose...</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('stripe_status') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group" wire:ignore>
                                                <label for="">Stripe Country Name</label>
                                                <select wire:model="stripe_country" name="stripe_country" id="stripe_country" class="select2 form-control" id="">
                                                    <option selected="">Choose...</option>
                                                    @foreach (config('country_list') as $key => $country)
                                                        <option value="{{ $key }}">{{ $country }}</option>
                                                    @endforeach
                                                </select>
                                                @error('stripe_country') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group" wire:ignore>
                                                <label for="">Stripe Currency</label>
                                                <select wire:model="stripe_currency" name="stripe_currency" id="stripe_currency" class="select2 form-control">
                                                    <option value="">Choose...</option>
                                                    @foreach (config('currencys.currency_list') as $currency)
                                                        <option @selected(config('settings.site_default_currency') === $currency) value="{{ $currency }}">{{ $currency }}</option>
                                                    @endforeach
                                                </select>
                                                @error('stripe_currency') <span class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="">Currency Rate ( Per {{config('settings.site_default_currency')}} )</label>
                                                <input wire:model="stripe_rate" name="stripe_rate" type="text" class="form-control">
                                                @error('stripe_rate') <span class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="">Stripe Key</label>
                                                <input wire:model="stripe_api_key" name="stripe_api_key" type="text" class="form-control">
                                                @error('stripe_api_key') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Stripe Secrete Key</label>
                                                <input wire:model="stripe_secret_key" name="stripe_secret_key" type="text" class="form-control">
                                                @error('stripe_secret_key') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>
                                                <div>
                                                    <div wire:loading wire:target="stripe_image" style="color: red">Uploading...</div>
                                                    <input wire:model="stripe_image" name="stripe_image" type="file" class="form-control" />
                                                    @error('stripe_image') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                @if ($stripe_image)
                                                    <img src="{{ $stripe_image->temporaryUrl() }}" class="p-1" width="80" height="80">
                                                @else
                                                    <img src="{{(!empty($stripe['stripe_image']))? url('/uploads/'.$stripe['stripe_image']) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                                                @endif
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
@script()
<script>
    // select2
    $(document).ready(function() {
        $('#stripe_status').select2();
        $('#stripe_status').on('change',function (){
            let data = $(this).val()
            console.log(data)
            $wire.set('stripe_status',data)
        });
    });
    // // select2
    $(document).ready(function() {
        $('#stripe_country').select2();
        $('#stripe_country').on('change',function (){
            let data = $(this).val()
            console.log(data)
            $wire.set('stripe_country',data)
        });
    });
    // select2
    $(document).ready(function() {
        $('#stripe_currency').select2();
        $('#stripe_currency').on('change',function (){
            let data = $(this).val()
            console.log(data)
            $wire.set('stripe_currency',data)
        });
    });
</script>
@endscript
