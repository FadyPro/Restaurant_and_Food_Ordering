<div>
    <div wire:ignore class="fp__related_menu mt_90 xs_mt_60">
        <h2>related item</h2>
        <div wire:ignore class="row">
            @foreach ($relatedProducts as $relatedProduct)
                <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_item">
                        <div class="fp__menu_item_img">
                            <img src="{{ asset('uploads/products/'.$relatedProduct->thumb_image) }}"
                                 alt="{{ $relatedProduct->name }}" class="img-fluid w-100">
                            <a class="category" href="#">{{ @$relatedProduct->category->name }}</a>
                        </div>
                        <div class="fp__menu_item_text">
                            <p class="rating">
{{--                            @if ($relatedProduct->reviews_avg_rating)--}}
{{--                                <p class="rating">--}}
{{--                                    @for ($i = 1; $i <= $relatedProduct->reviews_avg_rating; $i++)--}}
{{--                                        <i class="fas fa-star"></i>--}}
{{--                                    @endfor--}}

{{--                                    <span>({{ $relatedProduct->reviews_count }})</span>--}}
{{--                                </p>--}}
{{--                                @endif--}}
                                </p>
                                <a class="title"
                                   href="{{ route('product-detail', $relatedProduct->slug) }}">{!! $relatedProduct->name !!}</a>
                                <h5 class="price">
                                    @if ($relatedProduct->offer_price > 0)
                                        {{ currencyPosition($relatedProduct->offer_price) }}
                                        <del>{{ currencyPosition($relatedProduct->price) }}</del>
                                    @else
                                        {{ currencyPosition($relatedProduct->price) }}
                                    @endif
                                </h5>
                                <ul class="d-flex flex-wrap justify-content-center">
                                    <li><a href="javascript:;" wire:click.prevent="openModal({{ $relatedProduct->id }})"> <i class="fas fa-shopping-basket"></i></a></li>
                                    <li><a href="javascript:;" wire:click="WishList({{ $relatedProduct->id }})"><i class="fal fa-heart"></i></a></li>
                                    <li><a href="/product-detail/{{ $relatedProduct->slug }}"><i class="far fa-eye"></i></a></li>
                                </ul>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
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
    </script>
</div>
