<div>
    <!--=============================
               BREADCRUMB START
           ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>cart view</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="#">cart view</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                BREADCRUMB END
            ==============================-->

    <!--============================
                CART VIEW START
            ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                <tr>
                                    <th class="fp__pro_img">
                                        Image
                                    </th>

                                    <th class="fp__pro_name">
                                        details
                                    </th>

                                    <th class="fp__pro_status">
                                        price
                                    </th>

                                    <th class="fp__pro_select">
                                        quantity
                                    </th>

                                    <th class="fp__pro_tk">
                                        total
                                    </th>

                                    <th class="fp__pro_icon">
                                        <a class="clear_all" href="#" wire:click.prevent="clearAllCart()">clear all</a>
                                    </th>
                                </tr>

                                @foreach (Cart::content() as $key=> $product)
                                    <tr>
                                        <td class="fp__pro_img"><img
                                                src="{{ 'uploads/products/'.$product->options->productInfo['image'] }}" alt="product"
                                                class="img-fluid w-100">
                                        </td>

                                        <td class="fp__pro_name">
                                            <a
                                                href="{{ route('product-detail', $product->options->productInfo['slug']) }}">{{ $product->name }}</a>
                                            <span>{{ @$product->options->productSize['name'] }}
                                                {{ @$product->options->productSize['price'] ? '(' . currencyPosition(@$product->options->productSize['price']) . ')' : '' }}</span>
                                            @foreach ($product->options->productOptions as $option)
                                                <p>{{ $option['name'] }} ({{ currencyPosition($option['price']) }})</p>
                                            @endforeach

                                        </td>

                                        <td class="fp__pro_status">
                                            <h6>{{ currencyPosition($product->price) }}</h6>
                                        </td>

                                        <td class="fp__pro_select">
                                            <div class="quentity_btn">
                                                <button wire:click.prevent="decrement('{{$product->rowId}}')" class="btn btn-danger"><i class="fal fa-minus"></i></button>
                                                <input type="text" id="quantity" name="quantity" placeholder="1" value="{{ $product->qty }}" readonly>
                                                <button wire:click.prevent="increment('{{$product->rowId}}')" class="btn btn-success"><i class="fal fa-plus"></i></button>
                                            </div>
                                        </td>
                                        <td class="fp__pro_tk">
                                            <h6 class="produt_cart_total">
                                                {{$this->ProductTotal($product->rowId)}}
                                            </h6>
                                        </td>

                                        <td class="fp__pro_icon">
                                            <a href="#" wire:click.prevent="removeProductFromCartView('{{ $product->rowId }}')" class="reomove_cart_product"><i class="far fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (Cart::content()->count() === 0)
                                    <tr>
                                        <td colspan="6" class="text-center fp__pro_name"
                                            style="width: 100%;display: inline;">Cart is empty!</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="subtotal">{{ currencyPosition($cartTotal) }}</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        <p>discount: <span id="discount">
                            @if (isset(session()->get('coupon')['discount']))
                                    {{ config('settings.site_currency_icon') }} {{ session()->get('coupon')['discount'] }}
                                @else
                                    {{ config('settings.site_currency_icon') }}0
                                @endif
                        </span></p>
                        <p class="total"><span>total:</span> <span id="final_total">
                            @if (isset(session()->get('coupon')['discount']))
                                    {{ config('settings.site_currency_icon') }} {{ $cartTotal - session()->get('coupon')['discount'] }}
                                @else
                                    {{ config('settings.site_currency_icon') }} {{ $cartTotal }}
                                @endif
                        </span></p>
                        <form wire:submit.prevent="applyCoupon">
                            @csrf
                            <input wire:model="code" type="text"  name="code" placeholder="Coupon Code">
                            @if(session()->has('coupon'))
                                <button DISABLED>apply</button>
                            @else
                                <button type="submit">apply</button>
                            @endif

                        </form>

                        <div class="coupon_card">
                            @if (session()->has('coupon'))
                                <div class="card mt-2">
                                    <div class="m-3">
                                        <span><b class="v_coupon_code">Applied Couppon: {{ session()->get('coupon')['code'] }}</b></span>
                                        <span>
                                    <button wire:click.prevent="destroyCoupon"><i class="far fa-times"></i></button>
                                </span>

                                    </div>
                                </div>
                            @endif
                        </div>

                        <a class="common_btn" href="{{ route('checkout.index') }}">checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                CART VIEW END
            ==============================-->

</div>
