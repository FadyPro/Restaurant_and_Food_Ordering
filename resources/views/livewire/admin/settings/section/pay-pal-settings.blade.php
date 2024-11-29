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
                                <a class="nav-link active" href="{{route('admin.setting.paypal-setting')}}">PayPal</a>
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
                                <a class="nav-link" href="{{route('admin.setting.mail-setting')}}">Mail Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.seo-setting')}}">Seo Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                        <div class="tab-content no-padding" id="myTab2Content">
                            <div class="tab-pane fade show active" id="paypal-setting" role="tabpanel" aria-labelledby="home-tab4">
                                <div class="card">
                                    <div class="card-body border">
                                        <form wire:submit.prevent="save">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Paypal Status</label>
                                                <select wire:model="paypal_status" name="paypal_status" id="paypal_status" class="select2 form-control">
                                                    <option selected="">Choose...</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('paypal_status') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group" wire:ignore>
                                                <label for="">Paypal Country Name</label>
                                                <select wire:model="paypal_country" name="paypal_country" id="paypal_country" class="select2 form-control" id="">
                                                    <option selected="">Choose...</option>
                                                    @foreach (config('country_list') as $key => $country)
                                                        <option value="{{ $key }}">{{ $country }}</option>
                                                    @endforeach
                                                </select>
                                                @error('paypal_country') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group" wire:ignore>
                                                <label for="">Paypal Currency</label>
                                                <select wire:model="paypal_currency" name="paypal_currency" id="paypal_currency" class="select2 form-control">
                                                    <option value="">Choose...</option>
                                                    @foreach (config('currencys.currency_list') as $currency)
                                                        <option @selected(config('settings.site_default_currency') === $currency) value="{{ $currency }}">{{ $currency }}</option>
                                                    @endforeach
                                                </select>
                                                @error('paypal_currency') <span class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="">Currency Rate ( Per {{config('settings.site_default_currency')}} )</label>
                                                <input wire:model="paypal_rate" name="paypal_rate" type="text" class="form-control">
                                                @error('paypal_rate') <span class="error">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="">Paypal Client ID</label>
                                                <input wire:model="paypal_api_key" name="paypal_api_key" type="text" class="form-control">
                                                @error('paypal_api_key') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Paypal Secrete Key</label>
                                                <input wire:model="paypal_secret_key" name="paypal_secret_key" type="text" class="form-control">
                                                @error('paypal_secret_key') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Paypal APP ID</label>
                                                <input wire:model="paypal_app_id" name="paypal_app_id" type="text" class="form-control">
                                                @error('paypal_app_id') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>
                                                <div>
                                                    <div wire:loading wire:target="paypal_image" style="color: red">Uploading...</div>
                                                    <input wire:model="paypal_image" name="paypal_image" type="file" class="form-control" />
                                                    @error('paypal_image') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                @if ($paypal_image)
                                                    <img src="{{ $paypal_image->temporaryUrl() }}" class="p-1" width="80" height="80">
                                                @else
                                                    <img src="{{(!empty($paypal['paypal_image']))? url('/uploads/'.$paypal['paypal_image']) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
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
