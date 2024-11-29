<div>
    <!--=============================
           BREADCRUMB START
       ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('uploads/'.config('settings.breadcrumb')) }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>checkout</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
            BREADCRUMB END
        ==============================-->


    <!--============================
            CHECK OUT PAGE START
        ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__checkout_form">
                        <div class="fp__check_form">
                            <h5>select address <a href="#" wire:click.prevent="openModal"><i
                                        class="far fa-plus"></i> add address</a></h5>

                            @if($isOpen)
                            <div class="fp__address_modal">
                                <div wire:ignore class="modal show"  tabindex="-1" aria-labelledby="address_modalLabel"
                                     style="display: block;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="address_modalLabel">add new address
                                                </h1>
                                                <button wire:click="closeModal()" type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="fp_dashboard_new_address d-block">
                                                    <form wire:submit.prevent="addAddress">
                                                        @csrf
                                                        <div class="row">

                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="fp__check_single_form">
                                                                    <select wire:model="delivery_area_id" class="nice-select" name="delivery_area_id">
                                                                        <option value="">Select Area</option>
                                                                        @foreach ($deliveryAreas as $area)
                                                                            <option value="{{ $area->id }}">
                                                                                {{ $area->area_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('delivery_area_id') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input wire:model="first_name" type="text" placeholder="First Name" name="first_name">
                                                                    @error('first_name') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input wire:model="last_name" type="text" placeholder="Last Name" name="last_name">
                                                                    @error('last_name') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input wire:model="phone" type="text" placeholder="Phone" name="phone">
                                                                    @error('phone') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input wire:model="email" type="text" placeholder="Email" name="email">
                                                                    @error('email') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="fp__check_single_form">
                                                                    <textarea wire:model="address" cols="3" rows="4" placeholder="Address" name="address"></textarea>
                                                                    @error('address') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="fp__check_single_form check_area">
                                                                    <div class="form-check">
                                                                        <input wire:model="type" class="form-check-input" type="radio"
                                                                               name="type" id="flexRadioDefault1"
                                                                               value="home">
                                                                        <label class="form-check-label"
                                                                               for="flexRadioDefault1">
                                                                            home
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input wire:model="type" class="form-check-input" type="radio"
                                                                               name="type" id="flexRadioDefault2"
                                                                               value="office">
                                                                        <label class="form-check-label"
                                                                               for="flexRadioDefault2">
                                                                            office
                                                                        </label>
                                                                    </div>
                                                                    @error('type') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div  style="display:flex;">
                                                                <button wire:click="closeModal()" style="width: 200px" type="button"
                                                                        class="common_btn cancel_new_address mr-2">cancel</button>
                                                                <button style="width: 200px" type="submit" class="common_btn">save
                                                                    address</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                @foreach ($addresses as $address)
                                    <div class="col-md-6">
                                        <div class="fp__checkout_single_address">
                                            <div class="form-check">
                                                <input wire:model="address_id" wire:click="CalculateDeliveryCharge" class="form-check-input v_address" value="{{ $address->id }}" type="radio" name="flexRadioDefault"
                                                       id="home">
                                                <label class="form-check-label" for="home">
                                                    @if ($address->type === 'home')
                                                        <span class="icon"><i class="fas fa-home"></i> home</span>
                                                    @else
                                                        <span class="icon"><i class="fas fa-home"></i> office</span>
                                                    @endif
                                                    <span class="address">{{ $address->address }},
                                                        {{ $address->deliveryArea?->area_name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span>{{ currencyPosition(cartTotal()) }}</span></p>
                        <p>delivery: <span id="delivery_fee">{{ currencyPosition($deliveryFee) }}</span></p>
                        @if (session()->has('coupon'))
                            <p>discount: <span>{{ currencyPosition(session()->get('coupon')['discount']) }}</span></p>
                        @else
                            <p>discount: <span>{{ currencyPosition(0) }}</span></p>

                        @endif
                        <p class="total"><span>total:</span> <span id="grand_total">{{ currencyPosition($total)}}</span></p>

                        <a wire:click="checkoutRedirect" class="common_btn"  href=" #">Proceed to Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
            CHECK OUT PAGE END
        ==============================-->
</div>
