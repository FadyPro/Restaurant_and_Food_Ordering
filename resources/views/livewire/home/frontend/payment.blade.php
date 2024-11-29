<div>
    <!--=============================
       BREADCRUMB START
   ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>payment</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">payment</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        PAYMENT PAGE START
    ==============================-->
    <section class="fp__payment_page mt_100 xs_mt_70 mb_100 xs_mb_70">
        <div class="container">
            <h2>Choose Your Payment Gateway</h2>
            <div class="row">
                <div class="col-lg-8">
                    <div class="fp__payment_area">
                        <div class="row">
                            @if(config('gatewaySettings.paypal_status'))
                                <div class="col-lg-3 col-6 col-sm-4 col-md-3 wow fadeInUp" data-wow-duration="1s">
                                    <a wire:click="makePayment('paypal')" class="fp__single_payment payment-card"
                                       href="#">
                                        <img src="{{ asset('uploads/'.config('gatewaySettings.paypal_image')) }}" alt="payment method" class="img-fluid w-100">
                                    </a>
                                </div>
                            @endif

                            @if(config('gatewaySettings.stripe_status'))
                                <div class="col-lg-3 col-6 col-sm-4 col-md-3 wow fadeInUp" data-wow-duration="1s">
                                    <a  wire:click="makePayment('stripe')" class="fp__single_payment payment-card"
                                       href="#">
                                        <img src="{{ asset('uploads/'.config('gatewaySettings.stripe_image')) }}" alt="payment method" class="img-fluid w-100">
                                    </a>
                                </div>
                            @endif
                            @if(config('gatewaySettings.paymob_status'))
                                <div class="col-lg-3 col-6 col-sm-4 col-md-3 wow fadeInUp" data-wow-duration="1s">
                                    <a  wire:click="makePayment('paymob')" class="fp__single_payment payment-card"
                                        href="#">
                                        <img src="{{ asset('uploads/'.config('gatewaySettings.paymob_image')) }}" alt="payment method" class="img-fluid w-100">
                                    </a>
                                </div>
                            @endif

                            @if(config('gatewaySettings.razorpay_status'))

                                <div class="col-lg-3 col-6 col-sm-4 col-md-3 wow fadeInUp" data-wow-duration="1s">
                                    <a class="fp__single_payment payment-card"
                                       href="#">
                                        <img src="{{ asset(config('gatewaySettings.razorpay_logo')) }}" alt="payment method" class="img-fluid w-100">
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt_25 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span>{{ currencyPosition($subtotal) }}</span></p>
                        <p>delivery: <span>{{ currencyPosition($delivery) }}</span></p>
                        <p>discount: <span>{{ currencyPosition($discount) }}</span></p>
                        <p class="total"><span>total:</span> <span>{{ currencyPosition($grandTotal) }}</span></p>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
