<div>
    <!-- Modal -->
    @if($selectId)
        <div wire:ignore.self class="modal show" id="ProductModal" tabindex="-1" aria-labelledby="ProductModal" aria-hidden="true" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel"></h5>
                        <button type="button" wire:click="closeModal()" class="btn-close" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- CART POPUT START -->
                        <form wire:submit.prevent="addCart">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="fp__cart_popup_img">
                                <img src="{{ asset(asset('uploads/products/'.$product->thumb_image)) }}" alt="{{ $product->name }}" class="img-fluid w-100">
                            </div>
                            <div class="fp__cart_popup_text">
                                <a href="{{ route('product-detail', $product->slug) }}" class="title">{!! $product->name !!}</a>
                                <p class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                    <span>(201)</span>
                                </p>
                                <h4 class="price">
                                    @if ($product->offer_price > 0)
                                        <input type="hidden" wire:model.live="basePrice" name="base_price" value="{{ $basePrice }}">
                                        {{ currencyPosition($product->offer_price) }}
                                        <del>{{ currencyPosition($product->price) }}</del>
                                    @else
                                        <input type="hidden" wire:model.live="basePrice" name="base_price" value="{{ $basePrice }}">
                                        {{ currencyPosition($product->price) }}
                                    @endif
                                </h4>

                                @if ($product->productSizes()->exists())
                                    <div class="details_size">
                                        <h5>select size</h5>
                                        @foreach ($product->productSizes as $key => $productSize)
                                            <div class="form-check">
                                                <input class="form-check-input" wire:model.live="productSizeId" type="radio" value="{{ $productSize->id }}"  name="product_size" >
                                                <label class="form-check-label" for="size-{{ $productSize->id }}">
                                                    {{ $productSize->name }} <span>+ {{ currencyPosition($productSize->price) }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                        @error('productSizeId') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                                @if ($product->productOptions()->exists())
                                    <div class="details_extra_item">
                                        <h5>select option <span>(optional)</span></h5>
                                        @foreach ($product->productOptions as $key=>$productOption)
                                            <div class="form-check">
                                                <input class="form-check-input" wire:model.live="productOptionPriceId" type="checkbox" name="product_option" value="{{ $productOption->id }}">
                                                <label class="form-check-label" for="option-{{ $productOption->id }}">
                                                    {{ $productOption->name }} <span>+ {{ currencyPosition($productOption->price) }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                        @error('productOptionPriceId') <span class="error">{{ $message }}</span> @enderror
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
                                        @if ($totalPrice > 0)
                                            <h3>{{ currencyPosition($totalPrice) }}</h3>
                                        @else
                                            <h3>{{ currencyPosition($basePrice) }}</h3>
                                        @endif
                                    </div>
                                    @error('quantity') <span class="error">{{ $message }}</span> @enderror
                                </div>
                                <ul class="details_button_area d-flex flex-wrap">
                                    @if ($product->quantity === 0)
                                        <li><button type="button" class="common_btn bg-danger">Stock Out</button></li>
                                    @else
                                        <li><button type="submit" class="common_btn modal_cart_button">add to cart</button></li>
                                    @endif
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <div class="modal-backdrop fade show"></div>
    @endif
    <!-- CART POPUT END -->
<style>
    .modal-dialog {
        max-width: 600px;
    }
</style>
</div>

