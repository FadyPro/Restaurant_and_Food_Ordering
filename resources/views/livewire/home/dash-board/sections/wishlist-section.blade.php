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

                                <button onclick="window.location='{!! route('address-section') !!}'" class="nav-link " id="v-pills-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-address" type="button" role="tab"
                                        aria-controls="v-pills-address" aria-selected="true"><span style="background-color: #fba35e"><i
                                            class="fas fa-user"></i></span>address</button>

                                <button onclick="window.location='{!! route('reservation-section') !!}'" class="nav-link" id="v-pills-reservation-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-reservation" type="button" role="tab"
                                        aria-controls="v-pills-reservation" aria-selected="false"><span style="background-color: #fba35e"><i
                                            class="fas fa-bags-shopping"></i></span> Reservations</button>

                                <button onclick="window.location='{!! route('order-section') !!}'" class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-profile" type="button" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false"><span style="background-color: #fba35e"><i
                                            class="fas fa-bags-shopping"></i></span> Order</button>

                                <button onclick="window.location='{!! route('wish-list-section') !!}'" class="nav-link active" id="v-pills-wishlist-tab2" data-bs-toggle="pill"
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
                    <div class="col-xl-9 col-lg-8 wow fadeInUp" id="v-pills-review" role="tabpanel"
                         aria-labelledby="v-pills-review-tab">
                        <div class="fp_dashboard_body">
                            <h3>Wishlist</h3>
                            <div class="fp_dashboard_order">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr class="t_header">
                                            <th>No</th>
                                            <th style="width: 40%">Product</th>
                                            <th>Stock</th>
                                            <th>action</th>

                                        </tr>
                                        @foreach ($wishlist as $item)
                                            <tr>
                                                <td>
                                                    <h5>{{ ++$loop->index }}</h5>
                                                </td>
                                                <td style="width: 40%">
                                                    {{ $item->product->name }}
                                                </td>
                                                <td>
                                                    @if ($item->product->quantity > 0)
                                                        <h5 class="text-success">In Stock</h5>
                                                    @else
                                                        <h5 class="text-danger">Out of Stock</h5>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('product-detail', $item->product->slug) }}" class="view_invoice">View Product</a>
                                                </td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    @if (count($wishlist) === 0)
                                        <p> ... showing no Results found </p>
                                    @endif
                                    <div>
                                        <br>
                                        {{$wishlist->onEachSide(2)->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <style>
        .modal-dialog {
            max-width: 600px;
        }
    </style>
    <!--=========================
        DASHBOARD END
    ==========================-->



</div>
