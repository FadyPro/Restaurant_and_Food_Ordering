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
                                <a class="nav-link active" href="{{route('admin.setting.logo-setting')}}">Logo Settings</a>
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
                        <div class="tab-content no-padding">
                            <div class="tab-pane fade show active">
                                <div class="card">
                                    <div class="card-body border">
                                        <form wire:submit.prevent="save">
                                            @csrf
                                            <div class="form-group">
                                                <label>Logo</label>
                                                <div>
                                                    <div wire:loading wire:target="logo" style="color: red">Uploading...</div>
                                                    <input wire:model="logo" name="logo" type="file" class="form-control" />
                                                    @error('logo') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                @if ($logo)
                                                    <img src="{{ $logo->temporaryUrl() }}" class="p-1" width="80" height="80">
                                                @else
                                                    <img src="{{(!empty($model['logo']))? url('/uploads/'.$model['logo']) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Footer Logo</label>
                                                <div>
                                                    <div wire:loading wire:target="footer_logo" style="color: red">Uploading...</div>
                                                    <input wire:model="footer_logo" name="footer_logo" type="file" class="form-control" />
                                                    @error('footer_logo') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                @if ($footer_logo)
                                                    <img src="{{ $footer_logo->temporaryUrl() }}" class="p-1" width="80" height="80">
                                                @else
                                                    <img src="{{(!empty($model['footer_logo']))? url('/uploads/'.$model['footer_logo']) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>favicon</label>
                                                <div>
                                                    <div wire:loading wire:target="favicon" style="color: red">Uploading...</div>
                                                    <input wire:model="favicon" name="favicon" type="file" class="form-control" />
                                                    @error('favicon') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                @if ($favicon)
                                                    <img src="{{ $favicon->temporaryUrl() }}" class="p-1" width="80" height="80">
                                                @else
                                                    <img src="{{(!empty($model['favicon']))? url('/uploads/'.$model['favicon']) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Breadcrumb</label>
                                                <div>
                                                    <div wire:loading wire:target="breadcrumb" style="color: red">Uploading...</div>
                                                    <input wire:model="breadcrumb" name="breadcrumb" type="file" class="form-control" />
                                                    @error('breadcrumb') <span class="error">{{ $message }}</span> @enderror
                                                </div>
                                                @if ($breadcrumb)
                                                    <img src="{{ $breadcrumb->temporaryUrl() }}" class="p-1" width="80" height="80">
                                                @else
                                                    <img src="{{(!empty($model['breadcrumb']))? url('/uploads/'.$model['breadcrumb']) : url('/uploads/no-image.png')}}" style="width: 80px; height: 80px">
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
