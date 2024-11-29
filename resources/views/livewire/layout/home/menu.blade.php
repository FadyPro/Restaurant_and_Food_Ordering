<div>

    <nav class="navbar navbar-expand-lg main_menu">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('uploads/'.config('settings.logo')) }}" alt="FoodPark" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="far fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav m-auto">
                    @php
                        $MainMenu = Menu::getByName('main_menu');
                    @endphp

                    @if ($MainMenu)
                        @foreach ($MainMenu as $menu)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $menu['link'] }}">{{ $menu['label'] }}
                                    @if ($menu['child'])
                                        <i class="far fa-angle-down"></i>
                                    @endif
                                </a>
                                @if ($menu['child'])
                                    <ul class="droap_menu">
                                        @foreach ($menu['child'] as $item)
                                            <li><a href="{{ $item['link'] }}">{{ $item['label'] }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @endif

                </ul>
                <ul class="menu_icon d-flex flex-wrap">
                    <li>
                        <a href="#" class="menu_search"><i class="far fa-search"></i></a>
                        <div class="fp__search_form">
                            <form action="" method="GET">
                                <span class="close_search"><i class="far fa-times"></i></span>
                                <input type="text" placeholder="Search . . ." name="search">
                                <button type="submit">search</button>
                            </form>
                        </div>
                    </li>
                    <li>
                            <a class="cart_icon"><i class="fas fa-shopping-basket"></i> <span class="cart_count">{{ count(Cart::content()) }}</span></a>
                    </li>
                    @php
                        //                        @$unseenMessages = \App\Models\Chat::where(['sender_id' => 1, 'receiver_id' => auth()->user()->id, 'seen' => 0])->count();
                    @endphp
                    <li>
                        <a class="message_icon"
                           href="{{ route('dashboard') }}">
                            {{--                            <span class="sunseen-message-count">{{ $unseenMessages > 0 ? 1 : 0 }}</span>--}}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}"><i class="fas fa-user"></i></a>
                    </li>
                    <li>
                        <a wire:click.prevent="openModal" class="common_btn" href="#">reservation</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="fp__menu_cart_area">
        <div class="fp__menu_cart_boody">
            <div class="fp__menu_cart_header">
                                <h5>total item (<span class="cart_count" style="font-size: 16px">{{ count(Cart::content()) }}</span>)</h5>
                <span class="close_cart"><i class="fal fa-times"></i></span>
            </div>
            <ul class="cart_contents">
                <input type="hidden" value="{{ $cartTotal }}" id="cart_total">
                <input type="hidden" value="{{ count(Cart::content()) }}" id="cart_product_count">
                                @foreach (Cart::content() as $cartProduct)
                                    <li>
                                        <div class="menu_cart_img">
                                            <img src="{{ asset('uploads/products/'.$cartProduct->options->productInfo['image']) }}" alt="menu" class="img-fluid w-100">
                                        </div>
                                        <div class="menu_cart_text">
                                            <a class="title" href="{{ route('product-detail', $cartProduct->options->productInfo['slug']) }}">{!! $cartProduct->name !!} </a>
                                            <p class="size">Qty: {{ $cartProduct->qty }}</p>

                                            <p class="size">{{ @$cartProduct->options->productSize['name'] }} {{ @$cartProduct->options->productSize['price'] ? '('.currencyPosition(@$cartProduct->options->productSize['price']).')' : '' }}</p>

                                            @foreach ($cartProduct->options->productOptions as $cartProductOption)
                                                <span class="extra">{{ $cartProductOption['name'] }} ({{ currencyPosition($cartProductOption['price']) }})</span>
                                            @endforeach

                                            <p class="price">{{ currencyPosition($cartProduct->price) }}</p>
                                        </div>
                                        <span class="del_icon" wire:click.prevent="removeProductFromSidebar('{{ $cartProduct->rowId }}')"><i class="fal fa-times"></i></span>
                                    </li>
                                @endforeach

            </ul>
                        <p class="subtotal">sub total <span class="cart_subtotal">{{ currencyPosition($cartTotal) }}</span></p>
                        <a class="cart_view" href="{{route('cart')}}"> view cart</a>
                        <a class="checkout" href="{{ route('checkout.index') }}">checkout</a>
        </div>
    </div>
    <!-- Modal -->
    @if($isOpen)
    <div wire:ignore class="fp__reservation">
        <div wire:ignore.self class="modal show" id="" tabindex="-1" aria-labelledby="ProductModal" aria-hidden="true" style="display: block;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Book a Table</h1>
                        <button type="button" class="btn-close" wire:click="closeModal()"></button>
                    </div>
                    <div wire:ignore class="modal-body">
                        <form wire:submit="reservation" class="fp__reservation_form">
                            @csrf
                            <div class="col-md-12">
                                <input wire:model="name" class="form-control" type="text" placeholder="Name" name="name">
                                @error('name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <br>
                            <div class="col-md-12">
                                <input wire:model="phone" class="form-control" type="text" placeholder="Phone" name="phone">
                                @error('phone') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <br>
                            <div class="col-md-12">
                                <input wire:model="date" class="form-control" type="date" name="date">
                                @error('date') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <br>
                            <div class="col-md-12">
                                <select wire:model="time" class="form-control" name="time">
                                    <option value="">select time</option>
                                    @foreach ($reservationTimes as $time)
                                        <option value="{{ $time->start_time }}-{{ $time->end_time }}">{{ $time->start_time }} to {{ $time->end_time }}</option>
                                    @endforeach
                                </select>
                                @error('time') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <br>
                            <div class="col-md-12">
                                <input wire:model="persons" class="form-control" type="text" placeholder="Persons" name="persons">
                                @error('persons') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <br>
                            <button type="submit" class="btn_submit">book table</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
