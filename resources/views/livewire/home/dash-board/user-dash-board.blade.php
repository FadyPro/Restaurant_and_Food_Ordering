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
                                        aria-selected="true"><span><i class="fas fa-user"></i></span> Personal Info</button>

                                <button onclick="window.location='{!! route('address-section') !!}'" class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-address" type="button" role="tab"
                                        aria-controls="v-pills-address" aria-selected="true"><span><i
                                            class="fas fa-user"></i></span>address</button>

                                <button onclick="window.location='{!! route('reservation-section') !!}'" class="nav-link" id="v-pills-reservation-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-reservation" type="button" role="tab"
                                        aria-controls="v-pills-reservation" aria-selected="false"><span><i
                                            class="fas fa-bags-shopping"></i></span> Reservations</button>

                                <button onclick="window.location='{!! route('order-section') !!}'" class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-profile" type="button" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false"><span><i
                                            class="fas fa-bags-shopping"></i></span> Order</button>

                                <button onclick="window.location='{!! route('wish-list-section') !!}'" class="nav-link" id="v-pills-wishlist-tab2" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-wishlist" type="button" role="tab"
                                        aria-controls="v-pills-wishlist" aria-selected="false"><span><i
                                            class="far fa-heart"></i></span> wishlist</button>

                                <button onclick="window.location='{!! route('reviews-section') !!}'" class="nav-link" id="v-pills-review-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-review" type="button" role="tab"
                                        aria-controls="v-pills-review" aria-selected="false"><span><i
                                            class="fas fa-star"></i></span> Reviews</button>
{{--                                @php--}}
{{--                                    $unseenMessages = \App\Models\Chat::where(['sender_id' => 1, 'receiver_id' => auth()->user()->id, 'seen' => 0])->count();--}}
{{--                                @endphp--}}
                                <button onclick="window.location='{!! route('message-section') !!}'" class="nav-link fp_chat_message" id="v-pills-message-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-message" type="button" role="tab"
                                        aria-controls="v-pills-message" aria-selected="false"><span><i
                                            class="far fa-comment-dots"></i></span> Message
{{--                                    <b class="sunseen-message-count">{{ $unseenMessages > 0 ? 1 : 0 }}</b>--}}
                                </button>

                                <button onclick="window.location='{!! route('chang-password') !!}'" class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-settings" type="button" role="tab" onclick="deleteSelf()"
                                        aria-controls="v-pills-settings" aria-selected="false"><span><i
                                            class="fas fa-user-lock"></i></span> Change Password </button>
                                <!-- Authentication -->
                                    <button wire:click="logout" style="width: 100%;" class="nav-link" type="button"><span> <i class="fas fa-sign-out-alt"></i>
                                    </span> Logout</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__dashboard_content">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="fp_dashboard_body">
                                    <h3>Welcome to your Profile</h3>

                                    <div class="fp__dsahboard_overview">
                                        <div class="row">
                                            <div class="col-xl-4 col-sm-6 col-md-4">
                                                <div class="fp__dsahboard_overview_item">
                                                    <span class="icon"><i class="far fa-shopping-basket"></i></span>
                                                    {{--                    <h4>total order <span>({{ $totalOrders }})</span></h4>--}}
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-md-4">
                                                <div class="fp__dsahboard_overview_item green">
                                                    <span class="icon"><i class="far fa-shopping-basket"></i></span>
                                                    {{--                    <h4>Completed <span>({{ $totalCompleteOrders }})</span></h4>--}}
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-md-4">
                                                <div class="fp__dsahboard_overview_item red">
                                                    <span class="icon" style="background-color: #0a53be"><i class="far fa-shopping-basket"></i></span>
                                                    {{--                    <h4>cancel <span>({{ $totalCancelOrders }})</span></h4>--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

{{--                                <livewire:home.dash-board.sections.change-password />--}}
{{--                                <livewire:home.dash-board.sections.address-section />--}}



{{--                                @include('frontend.dashboard.sections.reservation-section')--}}

{{--                                @include('frontend.dashboard.sections.order-section')--}}

{{--                                @include('frontend.dashboard.sections.message-section')--}}

{{--                                @include('frontend.dashboard.sections.wishlist-section')--}}

{{--                                @include('frontend.dashboard.sections.review-section')--}}

{{--                                @include('frontend.dashboard.change-password')--}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!--=========================
        DASHBOARD END
    ==========================-->
</div>

