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
                                <a class="nav-link" href="{{route('admin.setting.mail-setting')}}">Mail Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{route('admin.setting.seo-setting')}}">Seo Settings</a>
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
                                                <label for="">Seo Title</label>
                                                <input wire:model="seo_title" name="seo_title" type="text" class="form-control">
                                                @error('seo_title') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Seo Description</label>
                                                <textarea wire:model="seo_description" name="seo_description" class="form-control"></textarea>
                                                @error('seo_description') <span class="error">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Seo Keywords</label>
                                                <input wire:model="seo_keywords" type="text" class="form-control inputtags" name="seo_keywords" value="{{ config('settings.seo_keywords') }}">
                                                @error('seo_keywords') <span class="error">{{ $message }}</span> @enderror
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
@push('scripts')
    <script>
        $(".inputtags").tagsinput('items');
    </script>
    <script>
        $('form').submit(function() {
            @this.set('seo_keywords', $('.inputtags').val());
        });
    </script>
@endpush
