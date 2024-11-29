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
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link active"  href="{{route('admin.setting.general-setting')}}">General Settings</a>
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
                                <a class="nav-link" href="{{route('admin.setting.mail-setting')}}">Mail Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin.setting.seo-setting')}}">Seo Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                        <div class="tab-content no-padding" id="myTab2Content">
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding">
                                    <div class="tab-pane fade show active">
                                        <div class="card">
                                            <div class="card-body border">
                                                <form wire:submit.prevent="save">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="">Site Name</label>
                                                        <input wire:model="site_name" name="site_name" type="text" class="form-control" value="{{config('settings.site_name')}}">
                                                        @error('site_name') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Site Email</label>
                                                                <input wire:model="site_email" name="site_email" type="text" class="form-control" value="{{config('settings.site_email')}}">
                                                                @error('site_email') <span class="error">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Site Phone</label>
                                                                <input wire:model="site_phone" name="site_phone" type="text" class="form-control" value="{{config('settings.site_phone')}}">
                                                                @error('site_phone') <span class="error">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Default Currency</label>
                                                        <select wire:model="site_default_currency" name="site_default_currency" id="site_default_currency" class="select2 form-control">
                                                            <option value="">Select</option>
                                                            @foreach (config('currencys.currency_list') as $currency)
                                                                <option @selected(config('settings.site_default_currency') === $currency) value="{{ $currency }}">{{ $currency }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('site_default_currency') <span class="error">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Currency Icon</label>
                                                                <input wire:model="site_currency_icon" name="site_currency_icon" type="text" class="form-control" value="{{ config('settings.site_currency_icon') }}">
                                                                @error('site_currency_icon') <span class="error">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Currency Icon Position</label>
                                                                <select wire:model="site_currency_icon_position" name="site_currency_icon_position" id="site_currency_icon_position" class="select2 form-control">
                                                                    <option value="">Select</option>
                                                                    <option @selected(config('settings.site_currency_icon_position') === 'right') value="right">Right</option>
                                                                    <option @selected(config('settings.site_currency_icon_position') === 'left') value="left">Left</option>
                                                                </select>
                                                                @error('site_currency_icon_position') <span class="error">{{ $message }}</span> @enderror
                                                            </div>
                                                        </div>
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
            </div>
        </div>
    </section>
</div>
