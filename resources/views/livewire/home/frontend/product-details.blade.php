<div>
        <!--=============================
                            BREADCRUMB START
                        ==============================-->
        <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }});">
            <div class="fp__breadcrumb_overlay">
                <div class="container">
                    <div class="fp__breadcrumb_text">
                        <h1>menu Details</h1>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><a href="javascript:;">menu Details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!--=============================
                                BREADCRUMB END
                            ==============================-->


        <!--=============================
                                MENU DETAILS START
                            ==============================-->
        <section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
            <div class="container">
                <div class="row">
                    <div wire:ignore class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                        <div wire:ignore class="exzoom hidden" id="exzoom">
                            <div wire:ignore class="exzoom_img_box fp__menu_details_images">
                                <ul wire:ignore class='exzoom_img_ul'>
                                    <li wire:ignore><img class="zoom ing-fluid w-100" src="{{ asset('uploads/products/'.$product->thumb_image) }}"
                                             alt="product"></li>

                                    @foreach ($product->productImages as $image)
                                        <li wire:ignore.self><img class="zoom ing-fluid w-100" src="{{ asset('uploads/products/'.$image->image) }}" alt="product">
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                            <div class="exzoom_nav"></div>
                            <p class="exzoom_btn">
                                <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                                </a>
                                <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__menu_details_text">
                            <h2>{!! $product->name !!}</h2>
                            @if ($productRate->reviews_avg_rating)
                                <p class="rating">
                                    @for ($i = 1; $i <= $productRate->reviews_avg_rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor

                                    <span>({{ $productRate->reviews_count }})</span>
                                </p>
                            @endif
                            <h3 class="price">
                                @if ($product->offer_price > 0)
                                    {{ currencyPosition($product->offer_price) }}
                                    <del>{{ currencyPosition($product->price) }}</del>
                                @else
                                    {{ currencyPosition($product->price) }}
                                @endif
                            </h3>
                            <p class="short_description">{!! $product->short_description !!}</p>

                            <form wire:submit="addCart">
                                @csrf
                                <input type="hidden" name="base_price" class="v_base_price"
                                       value="{{ $product->offer_price > 0 ? $product->offer_price : $product->price }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                @if ($product->productSizes()->exists())
                                    <div class="details_size">
                                        <h5>select size</h5>

                                        @foreach ($product->productSizes as $productSize)
                                            <div class="form-check">
                                                <input class="form-check-input v_product_size" type="radio" wire:model.live="productSizeId"
                                                       name="product_size" value="{{ $productSize->id }}">
                                                <label class="form-check-label" for="size-{{ $productSize->id }}">
                                                    {{ $productSize->name }} <span>+
                                                    {{ currencyPosition($productSize->price) }}</span>
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                                @if ($product->productOptions()->exists())
                                    <div class="details_extra_item">
                                        <h5>select option <span>(optional)</span></h5>
                                        @foreach ($product->productOptions as $productOption)
                                            <div class="form-check">
                                                <input wire:model.live="productOptionPriceId" class="form-check-input v_product_option" name="product_option[]"
                                                       type="checkbox" value="{{ $productOption->id }}">
                                                <label class="form-check-label" for="option-{{ $productOption->id }}">
                                                    {{ $productOption->name }} <span>+
                                                    {{ currencyPosition($productOption->price) }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="details_quentity">
                                    <h5>select quentity</h5>
                                    <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                        <div class="quentity_btn">
                                            <button wire:click.prevent="decrement" class="btn btn-danger"><i class="fal fa-minus"></i></button>
                                            <input type="text" id="quantity" name="quantity" placeholder="1" value="{{ $count }}" readonly>
                                            <button wire:click.prevent="increment" class="btn btn-success"><i class="fal fa-plus"></i></button>
                                        </div>
                                        <h3 id="v_total_price">
                                            @if ($totalPrice > 0)
                                                <h3>{{ currencyPosition($totalPrice) }}</h3>
                                            @else
                                                <h3>{{ currencyPosition($basePrice) }}</h3>
                                            @endif
{{--                                            {{ $product->offer_price > 0 ? currencyPosition($product->offer_price) : currencyPosition($product->price) }}--}}
                                        </h3>
                                    </div>
                                </div>
                                <ul class="details_button_area d-flex flex-wrap">
                                    @if ($product->quantity === 0)
                                        <li><a class="common_btn bg-danger" href="javascript:;">Stock Out</a></li>
                                    @else
                                        <li><button type="submit" class="common_btn modal_cart_button">add to cart</button></li>
                                    @endif
                                    <li><a class="wishlist" wire:click="WishList" href="javascript:;" style="margin-left: 8px"><i class="far fa-heart"></i></a></li>
                                </ul>
                            </form>


                        </div>
                    </div>
                    <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__menu_description_area mt_100 xs_mt_70">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                            aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false">Reviews</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                     aria-labelledby="pills-home-tab" tabindex="0">
                                    <div class="menu_det_description">
                                        {!! $product->long_description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                     aria-labelledby="pills-contact-tab" tabindex="0">
                                    <div class="fp__review_area">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4>{{ count($reviews) }} reviews</h4>
                                                <div class="fp__comment pt-0 mt_20">
                                                    @foreach ($reviews as $review)
                                                        <div class="fp__single_comment m-0 border-0">
                                                            <img src="{{(!empty($review->user->avatar))? url('/uploads/avatars/'.$review->user->avatar) : url('/uploads/avatar.png')}}" alt="review" class="img-fluid">

                                                            <div class="fp__single_comm_text">
                                                                <h3>{{ $review->user->name }} <span>{{ date('d m Y', strtotime($review->created_at)) }} </span></h3>
                                                                <span class="rating">
                                                            @for ($i = 1; $i <= $review->rating; $i++)
                                                                        <i class="fas fa-star"></i>
                                                                    @endfor


                                                        </span>
                                                                <p>{{ $review->review }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @if ($reviews->hasPages())
                                                        <div class="fp__pagination mt_60">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    {{ $reviews->links() }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (count($reviews) === 0)
                                                        <div class="alert alert-warning mt-4">No review found!</div>
                                                    @endif

                                                </div>

                                            </div>
                                            @auth
                                                <div class="col-lg-4">
                                                    <div class="fp__post_review">
                                                        <h4>write a Review</h4>
                                                        <form wire:submit="productReviewStore" method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-xl-12 mt-2">
                                                                    <label for="">select your rating : </label>
                                                                    <div class="form-group">
                                                                        <div class="form-check-inline">
                                                                            <label class="form-check-label" for="1">
                                                                                <input wire:model="rating" type="radio" id="1" value="1" name="rating" class="rating" />
                                                                                <span class="wpcomment-input-option-label wpcomment-label-radio">1</span>
                                                                            </label>
                                                                        </div>

                                                                        <div class="form-check-inline">
                                                                            <label class="form-check-label" for="2">
                                                                                <input wire:model="rating" type="radio" id="2" value="2" name="rating" class="rating" checked="checked" />
                                                                                <span class="wpcomment-input-option-label wpcomment-label-radio">2</span>
                                                                            </label>
                                                                        </div>

                                                                        <div class="form-check-inline">
                                                                            <label class="form-check-label" for="3">
                                                                                <input wire:model="rating" type="radio" id="3" value="3" name="rating" class="rating" />
                                                                                <span class="wpcomment-input-option-label wpcomment-label-radio">3</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check-inline">
                                                                            <label class="form-check-label" for="4">
                                                                                <input wire:model="rating" type="radio" id="4" value="4" name="rating" class="rating" />
                                                                                <span class="wpcomment-input-option-label wpcomment-label-radio">3</span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check-inline">
                                                                            <label class="form-check-label" for="5">
                                                                                <input wire:model="rating" type="radio" id="5" value="5" name="rating" class="rating" />
                                                                                <span class="wpcomment-input-option-label wpcomment-label-radio">3</span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-12">
                                                                    <label for="">Review</label>
                                                                    <textarea wire:model="review" style="margin-top: 2px" name="review" rows="3" placeholder="Write your review"></textarea>
                                                                    @error('review') <span class="error">{{ $message }}</span> @enderror
                                                                </div>
                                                                <div class="col-12">
                                                                    <button class="common_btn" type="submit">submit
                                                                        review</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-4">
                                                    <h4>write a Review</h4>
                                                    <div class="alert alert-warning mt-4">Please login first to add review.</div>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (count($relatedProducts) > 0)
                    <livewire:home.frontend.related-products :product="$product" />
                @endif
            </div>
        </section>
    <style>
        .form-group {
            display: flex;
        }

        .form-check-inline .rating {
            display: none;
        }

        .form-check-inline span {
            padding-right: 2%;
            cursor: pointer;
            color: transparent;
            font-size: 35px;
        }

        .form-check-inline span:before {
            content: '\2606';
            color: gold;
        }

        .form-check-inline span:hover:before,
        .form-check-inline span:hover~span:before {
            content: '\2605';
            color: #F86F03;
        }

        .form-check-inline .rating:checked~span:before {
            content: '\2605';
            color: #F86F03;
        }

        .form-group:has(input[id="2"]:checked) input[id='1']+span:before {
            content: '\2605';
            color: #F86F03;
        }

        .form-group:has(input[id="3"]:checked) input[id='1']+span:before,
        .form-group:has(input[id="3"]:checked) input[id='2']+span:before {
            content: '\2605';
            color: #F86F03;
        }

        .form-group:has(input[id="2"]:hover) input[id='1']+span:before {
            content: '\2605';
            color: #F86F03;
        }

        .form-group:has(input[id="3"]:hover) input[id='1']+span:before,
        .form-group:has(input[id="3"]:hover) input[id='2']+span:before {
            content: '\2605';
            color: #F86F03;
        }

        .form-group:has(input[id="2"]:hover) input[id='2']+span:before {
            content: '\2605';
            color: #F86F03;
        }
        .form-group:has(input[id="4"]:hover) input[id='1']+span:before,
        .form-group:has(input[id="4"]:hover) input[id='2']+span:before,
        .form-group:has(input[id="4"]:hover) input[id='3']+span:before {
            content: '\2605';
            color: #F86F03;
        }
        .form-group:has(input[id="4"]:checked) input[id='1']+span:before,
        .form-group:has(input[id="4"]:checked) input[id='2']+span:before,
        .form-group:has(input[id="4"]:checked) input[id='3']+span:before {
            content: '\2605';
            color: #F86F03;
        }
        .form-group:has(input[id="5"]:hover) input[id='1']+span:before,
        .form-group:has(input[id="5"]:hover) input[id='2']+span:before,
        .form-group:has(input[id="5"]:hover) input[id='3']+span:before,
        .form-group:has(input[id="5"]:hover) input[id='4']+span:before {
            content: '\2605';
            color: #F86F03;
        }
        .form-group:has(input[id="5"]:checked) input[id='1']+span:before,
        .form-group:has(input[id="5"]:checked) input[id='2']+span:before,
        .form-group:has(input[id="5"]:checked) input[id='3']+span:before,
        .form-group:has(input[id="5"]:checked) input[id='4']+span:before {
            content: '\2605';
            color: #F86F03;
        }
    </style>

</div>

