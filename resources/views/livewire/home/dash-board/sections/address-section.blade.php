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

                                <button onclick="window.location='{!! route('address-section') !!}'" class="nav-link active" id="v-pills-address-tab" data-bs-toggle="pill"
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
                                                                        <h4>total order <span>({{ $totalOrders }})</span></h4>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-md-4">
                                                <div class="fp__dsahboard_overview_item green">
                                                    <span class="icon"><i class="far fa-shopping-basket"></i></span>
                                                                        <h4>Completed <span>({{ $totalCompleteOrders }})</span></h4>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-sm-6 col-md-4">
                                                <div class="fp__dsahboard_overview_item red">
                                                    <span class="icon" style="background-color: #0a53be"><i class="far fa-shopping-basket"></i></span>
                                                                        <h4>cancel <span>({{ $totalCancelOrders }})</span></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="fp_dashboard_body address_body">
                                            <h3>address <a class="dash_add_new_address" ><i class="far fa-plus"></i> add new
                                                </a>
                                            </h3>
                                            <div class="fp_dashboard_address show_edit_address">
                                                <div class="fp_dashboard_existing_address">
                                                    <div class="row">
                                                        @foreach ($userAddresses as $address)
                                                            <div class="col-md-6">
                                                                <div class="fp__checkout_single_address">
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                        <span class="icon">
                                                                            @if ($address->type === 'home')
                                                                                <i class="fas fa-home"></i>
                                                                            @else
                                                                                <i class="far fa-car-building"></i>
                                                                            @endif

                                                                            {{ $address->type }}
                                                                        </span>
                                                                            <span class="address">{{ $address->address }},
                                                                               {{ $address->deliveryArea?->area_name }} </span>
                                                                        </label>
                                                                    </div>
                                                                    <ul>
                                                                        <li><a href="javascript:;" wire:click.prevent="edit({{$address->id}})" data-class="edit_section_{{ $address->id }}"><i class="far fa-edit"></i></a></li>
                                                                        <li><a href="javascript:;" wire:click.prevent="deleteOne({{$address->id}})" class="dash_del_icon delete-item" ><i class="fas fa-trash-alt"></i></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                                <div class="fp_dashboard_new_address ">
                                                    <form wire:submit.prevent="save">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h4>Add New Address</h4>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="fp__check_single_form">
                                                                    <select wire:model="delivery_area_id" class="form-control" name="delivery_area_id">
                                                                        <option value="">Select Area</option>
                                                                        @foreach ($deliveryAreas as $area)
                                                                            <option value="{{ $area->id }}">{{ $area->area_name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                    @error('delivery_area_id') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input wire:model="first_name" type="text" placeholder="First Name" class="form-control" name="first_name">
                                                                    @error('first_name') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input wire:model="last_name" type="text" placeholder="Last Name" name="last_name" class="form-control">
                                                                    @error('last_name') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input wire:model="phone" type="text" placeholder="Phone" name="phone" class="form-control">
                                                                    @error('phone') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input wire:model="email" type="text" placeholder="Email" name="email" class="form-control">
                                                                    @error('email') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="fp__check_single_form">
                                                                    <textarea wire:model="address" cols="3" rows="4" placeholder="Address" name="address" class="form-control"></textarea>
                                                                    @error('address') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="fp__check_single_form check_area">
                                                                    <div class="form-check">
                                                                        <input wire:model="type" class="form-check-input" type="radio" name="type" id="flexRadioDefault1"
                                                                               value="home">
                                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                                            home
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input wire:model="type" class="form-check-input" type="radio" name="type" id="flexRadioDefault2"
                                                                               value="office">
                                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                                            office
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                @error('type') <span class="error">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="button" class="common_btn cancel_new_address">cancel</button>
                                                                <button type="submit" class="common_btn">save
                                                                    address</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                @if($isOpen)
                                                    <div class="fp__address_modal">
                                                    <div wire:ignore class="modal show" id="ProductModal" tabindex="-1" aria-labelledby="ProductModal" aria-hidden="true" style="display: block;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="address_modalLabel">Edit Address
                                                                    </h1>
                                                                    <button type="button" wire:click="closeModal()" class="btn-close" data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                        <div class="fp_dashboard_edit_address d-block">
                                                                            <form wire:submit.prevent="update">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <h4></h4>
                                                                                    </div>

                                                                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                                                                        <div class="fp__check_single_form">
                                                                                            <select wire:model="delivery_area_id" name="delivery_area_id" class="form-control">
                                                                                                <option value="">Select Area</option>
                                                                                                @foreach ($deliveryAreas as $area)
                                                                                                    <option @selected($address->delivery_area_id === $area->id) value="{{ $area->id }}">{{ $area->area_name }}</option>
                                                                                                @endforeach

                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br>
                                                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                                                        <div class="fp__check_single_form">
                                                                                            <input wire:model="first_name" type="text" placeholder="First Name" class="form-control" name="first_name">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                                                        <div class="fp__check_single_form">
                                                                                            <input wire:model="last_name" type="text" placeholder="Last Name" name="last_name" class="form-control">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                                                        <div class="fp__check_single_form">
                                                                                            <input wire:model="phone" type="text" placeholder="Phone" name="phone" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                                                                        <div class="fp__check_single_form">
                                                                                            <input wire:model="email" type="text" placeholder="Email" name="email" class="form-control">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                                                                        <div class="fp__check_single_form">
                                                                                            <textarea wire:model="address" cols="3" rows="4" placeholder="Address" name="address" class="form-control"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-12">
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
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div  style="display:flex;">
                                                                                        <button style="width: 200px" type="button" wire:click="closeModal()"
                                                                                                class="common_btn cancel_new_address mr-2">cancel</button>
                                                                                        <button wire:click.prevent="update" style="width: 200px" type="submit" class="common_btn">Update
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
    <style>
        .modal-dialog {
            max-width: 600px;
        }
    </style>
    <!--=========================
        DASHBOARD END
    ==========================-->
</div>


