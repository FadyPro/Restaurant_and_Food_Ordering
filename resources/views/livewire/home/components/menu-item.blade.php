<div>
    <section class="fp__menu mt_95 xs_mt_65">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="fp__section_heading mb_45">
                        <h4>food Menu</h4>
                        <h2>Our Popular Delicious Foods</h2>
                        <span>
                        <img src="{{asset('/frontend/images/heading_shapes.png')}}" alt="shapes" class="img-fluid w-100">
                    </span>
                        <p>Objectively pontificate quality models before intuitive information. Dramatically
                            recaptiualize multifunctional materials.</p>
                    </div>
                </div>
            </div>

            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-12">
                    <div class="menu_filter d-flex flex-wrap justify-content-center">

                        <button class="active button-click }}" data-filter="">all</button>
                        @foreach ($categories as $category)
                            <button class="{{ $loop->index === 10 ? 'active button-click' : '' }}" data-filter=".{{ $category->slug }}">{{ $category->name }}</button>
{{--                            <button class="{{ $loop->index === 0 ? 'active button-click' : '' }}" data-filter=".{{ $category->slug }}">{{ $category->name }}</button>--}}
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="row grid">
                @foreach ($categories as $category)
                    @php
                           $products = \App\Models\Product::where(['show_at_home' => 1, 'status' => 1, 'category_id' => $category->id])
                               ->orderBy('id', 'DESC')
                               ->take(8)
                               ->withAvg('reviews', 'rating')
                               ->withCount('reviews')
                               ->get();
                    @endphp

                    @foreach ($products as $product)
                        <div  class="col-xl-3 col-sm-6 col-lg-4 {{ $category->slug }}">
                            <div class="fp__menu_item">
                                <div class="fp__menu_item_img">
                                    <img src="{{ asset('uploads/products/'.$product->thumb_image) }}" alt="{{ $product->name }}" class="img-fluid w-100">
                                    <a class="category" href="#">{{ @$product->category->name }}</a>
                                </div>
                                <div class="fp__menu_item_text">
                                    @if ($product->reviews_avg_rating)
                                        <p class="rating">
                                            @for ($i = 1; $i <= $product->reviews_avg_rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor

                                            <span>{{ $product->reviews_count }}</span>
                                        </p>
                                    @endif
                                    <a class="title" href="/product-detail/{{ $product->slug }}">{{ $product->name }}</a>
                                    <h5 class="price">
                                        @if ($product->offer_price > 0)
                                            {{ currencyPosition($product->offer_price) }}
                                            <del>{{ currencyPosition($product->price) }}</del>
                                        @else
                                            {{ currencyPosition($product->price) }}
                                        @endif
                                    </h5>
                                    <ul class="d-flex flex-wrap justify-content-center">
{{--                                        <li><a href="javascript:;" @click="$dispatch('productModal',{id:{{ $product->id }}})" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fas fa-shopping-basket"></i></a></li>--}}
                                        <li><a href="javascript:;" wire:click="openModal({{ $product->id }})"> <i class="fas fa-shopping-basket"></i></a></li>
                                        <li><a href="javascript:;" wire:click="WishList({{ $product->id }})"><i class="fal fa-heart"></i></a></li>
                                        <li><a href="/product-detail/{{ $product->slug }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach

            </div>
        </div>
    </section>


    <!--=============================
                  CART POPUP START
      ==============================-->
@if($isOpen)
        <livewire:home.components.cart-popup :selectId="$selectId"/>
@endif
    <!--=============================
            CART POPUP END
   ==============================-->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('hideModal', (event) => {
                $('#ProductModal').modal('hide');
                $('#ProductModal').removeClass('modal');
                $('#ProductModal').removeClass('modal-backdrop');
                $('.modal').remove();
                $('.modal-backdrop').remove();
            });
        });
        document.addEventListener('livewire:init', () => {
            Livewire.on('showModal', (event) => {
                $('#ProductModal').modal('show');
            });
        });
        window.addEventListener('refresh-page', event => {
            window.location.reload(false);
        })
    </script>
</div>




