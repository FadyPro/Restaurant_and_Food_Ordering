<div>
    <!--=============================
       BREADCRUMB START
   ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ config('settings.breadcrumb') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>user dashboard</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=========================
        DASHBOARD START
    ==========================-->
    <section class="fp__dashboard mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <div class="fp__dashboard_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__dashboard_menu">
                            <div class="dasboard_header">
                                <div class="dasboard_header_img">
                                    <img src="{{(!empty(auth()->user()->avatar))? url('/uploads/avatars/'.auth()->user()->avatar) : url('/uploads/avatar.png')}}" alt="user" class="img-fluid w-100">
                                </div>
                                <h2>{{ auth()->user()->name }}</h2>
                            </div>
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">

                                <button onclick="window.location='{!! route('personal-info') !!}'" class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                                        aria-selected="true"><span style="background-color: #fba35e"><i class="fas fa-user"></i></span> Personal Info</button>

                                <button onclick="window.location='{!! route('address-section') !!}'" class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-address" type="button" role="tab"
                                        aria-controls="v-pills-address" aria-selected="true"><span style="background-color: #fba35e"><i
                                            class="fas fa-user"></i></span>address</button>

                                <button onclick="window.location='{!! route('reservation-section') !!}'" class="nav-link" id="v-pills-reservation-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-reservation" type="button" role="tab"
                                        aria-controls="v-pills-reservation" aria-selected="false"><span style="background-color: #fba35e"><i
                                            class="fas fa-bags-shopping"></i></span> Reservations</button>

                                <button onclick="window.location='{!! route('order-section') !!}'" class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-profile" type="button" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false"><span style="background-color: #fba35e"><i
                                            class="fas fa-bags-shopping"></i></span> Order</button>

                                <button onclick="window.location='{!! route('wish-list-section') !!}'" class="nav-link" id="v-pills-wishlist-tab2" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-wishlist" type="button" role="tab"
                                        aria-controls="v-pills-wishlist" aria-selected="false"><span style="background-color: #fba35e"><i
                                            class="far fa-heart"></i></span> wishlist</button>

                                <button onclick="window.location='{!! route('reviews-section') !!}'" class="nav-link" id="v-pills-review-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-review" type="button" role="tab"
                                        aria-controls="v-pills-review" aria-selected="false"><span style="background-color: #fba35e"><i
                                            class="fas fa-star"></i></span> Reviews</button>
                                {{--                                @php--}}
                                {{--                                    $unseenMessages = \App\Models\Chat::where(['sender_id' => 1, 'receiver_id' => auth()->user()->id, 'seen' => 0])->count();--}}
                                {{--                                @endphp--}}
                                <button onclick="window.location='{!! route('message-section') !!}'" class="nav-link fp_chat_message" id="v-pills-message-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-message" type="button" role="tab"
                                        aria-controls="v-pills-message" aria-selected="false"><span style="background-color: #fba35e"><i
                                            class="far fa-comment-dots"></i></span> Message
                                    {{--                                    <b class="sunseen-message-count">{{ $unseenMessages > 0 ? 1 : 0 }}</b>--}}
                                </button>

                                <button onclick="window.location='{!! route('chang-password') !!}'" class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-settings" type="button" role="tab" onclick="deleteSelf()"
                                        aria-controls="v-pills-settings" aria-selected="false"><span style="background-color: #fba35e"><i
                                            class="fas fa-user-lock"></i></span> Change Password </button>
                                <!-- Authentication -->
                                <button wire:click="logout" style="width: 100%;" class="nav-link" type="button"><span style="background-color: #fba35e"> <i class="fas fa-sign-out-alt"></i>
                                    </span> Logout</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12 col-12">
                        @foreach ($orders as $order)
                            <div class="fp__invoice invoice_details_{{ $order->id }}">
                                <a href="/order-section" class="go_back"><i class="fas fa-long-arrow-alt-left"></i> go back</a>
                                <div class="fp__track_order d-print-none">
                                    <ul>

                                        @if ($order->order_status === 'declined')

                                            <li class="declined_status{{ in_array($order->order_status, ['declined']) ? 'active' : '' }}">order declined</li>
                                        @else
                                            <li class="{{ in_array($order->order_status, ['pending', 'in_process', 'delivered', 'declined']) ? 'active' : '' }}">order pending</li>
                                            <li class="{{ in_array($order->order_status, ['in_process', 'delivered', 'declined']) ? 'active' : '' }}">order in process</li>
                                            <li class="{{ in_array($order->order_status, ['delivered']) ? 'active' : '' }}">order delivered</li>
                                        @endif
                                        {{-- <li>on decliend</li> --}}
                                    </ul>
                                </div>
                                <div class="fp__invoice_header">
                                    <div class="header_address">
                                        <h4>invoice to</h4>
                                        <p>{{ @$order->userAddress->first_name }}</p>
                                        <p>{{ $order->address }}</p>
                                        <p>{{ @$order->userAddress->phone }}</p>
                                        <p>{{ @$order->userAddress->email }}</p>

                                    </div>
                                    <div class="header_address" style="width: 50%">
                                        <p><b style="width: 140px">invoice no: </b><span>{{ @$order->invoice_id }}</span></p>
                                        <p><b style="width: 140px">Payment Status: </b><span>{{ @$order->payment_status }}</span></p>
                                        <p><b style="width: 140px">Payment Method: </b><span>{{ @$order->payment_method }}</span></p>
                                        <p><b style="width: 140px">Transaction Id: </b><span>{{ @$order->transaction_id }}</span></p>



                                        <p><b style="width: 140px">date:</b> <span>{{ date('d-m-Y', strtotime($order->created_at)) }}</span></p>
                                    </div>
                                </div>
                                <div class="fp__invoice_body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                            <tr class="border_none">
                                                <th class="sl_no">SL</th>
                                                <th class="package">item description</th>
                                                <th class="price">Price</th>
                                                <th class="qnty">Quantity</th>
                                                <th class="total">Total</th>
                                            </tr>

                                            @foreach ($order->orderItems as $item)
                                                @php
                                                    $size = json_decode($item->product_size);
                                                    $options = json_decode($item->product_option);

                                                    $qty = $item->qty;
                                                    $untiPrice = $item->unit_price;
                                                    $sizePrice = $size->price ?? 0;

                                                    $optionPrice = 0;
                                                    foreach ($options as $optionItem) {
                                                        $optionPrice += $optionItem->price;
                                                    }

                                                    $productTotal = ($untiPrice + $sizePrice + $optionPrice) * $qty;
                                                @endphp
                                                <tr>
                                                    <td class="sl_no">{{ ++$loop->index }}</td>
                                                    <td class="package">
                                                        <p>{{ $item->product_name }}</p>
                                                        <span class="size">{{ @$size->name }} - {{ @$size->price ? currencyPosition(@$size->price) : ''}}</span>
                                                        @foreach ($options as $option)
                                                            <span class="coca_cola">{{ @$option->name }} - {{ @$option->price ? currencyPosition(@$option->price) : '' }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td class="price">
                                                        <b>{{ currencyPosition($item->unit_price) }}</b>
                                                    </td>
                                                    <td class="qnty">
                                                        <b>{{ $item->qty }}</b>
                                                    </td>
                                                    <td class="total">
                                                        <b>{{ currencyPosition($productTotal) }}</b>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td class="package" colspan="3">
                                                    <b>sub total</b>
                                                </td>
                                                <td class="qnty">
                                                    <b>-</b>
                                                </td>
                                                <td class="total">
                                                    <b>{{ currencyPosition($order->subtotal) }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="package coupon" colspan="3">
                                                    <b>(-) Discount coupon</b>
                                                </td>
                                                <td class="qnty">
                                                    <b></b>
                                                </td>
                                                <td class="total coupon">
                                                    <b>{{ currencyPosition($order->discount) }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="package coast" colspan="3">
                                                    <b>(+) Shipping Cost</b>
                                                </td>
                                                <td class="qnty">
                                                    <b></b>
                                                </td>
                                                <td class="total coast">
                                                    <b>{{ currencyPosition($order->delivery_charge) }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="package" colspan="3">
                                                    <b>Total Paid</b>
                                                </td>
                                                <td class="qnty">
                                                    <b></b>
                                                </td>
                                                <td class="total">
                                                    <b>{{ currencyPosition($order->grand_total) }}</b>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <a class="print_btn common_btn" href="javascript:;" wire:click="pdfInvoice"><i class="far fa-print "></i> print
                                    PDF</a>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
