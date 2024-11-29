<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductRating;
use App\Models\ProductSize;
use App\Models\Wishlist;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.home.master')]
class ProductDetails extends Component
{
    public $relatedProducts;
    public $count = 1;
    public $saved = false;
    public $name, $slug, $show_at_home, $status, $thumb_image, $category_id, $short_description,
        $long_description, $price, $offer_price, $quantity, $sku, $seo_title, $seo_description, $id,$rating = 2,$review;
    public $product;
    public $product_id, $selectId;
    public $isOpen = 0;
    public $basePrice;
    public $productSizeId;
    public $selectedSizePrice;
    public array  $productOptionPriceId = [];
    public $totalPrice;

    public function mount(string $slug)
    {
        $product = Product::with(['productImages', 'productSizes', 'productOptions'])->where(['slug' => $slug, 'status' => 1])
            ->firstOrFail();
        $this->product = $product;
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)->take(8)
            ->latest()->get();
        $this->relatedProducts = $relatedProducts;
        $this->basePrice = $product->offer_price > 0 ? $product->offer_price : $product->price;
        $this->price = $product->price;
        $this->offer_price = $product->offer_price;
        $this->quantity = $product->quantity;
        $this->product_id = $product->id;
    }
    public function render()
    {
        $reviews = ProductRating::where(['product_id' => $this->product_id, 'status' => 1])->paginate(30);
        $productRate = $this->product->withAvg('reviews', 'rating')->withCount('reviews')->where(['id' => $this->product_id, 'status' => 1])->first();
        return view('livewire.home.frontend.product-details', compact('reviews', 'productRate'));
    }
    public function alertSuccess($rel)
    {
        $this->dispatch('alert',
            ['types' => 'success', 'message' => $rel]);
    }

    public function alertDelete($rel)
    {
        $this->dispatch('alert',
            ['types' => 'error', 'message' => $rel]);
    }
    public function increment()
    {
        $product = Product::select('quantity')->findOrFail($this->product_id);
        if($product->quantity <= $this->count){
            $this->alertDelete('Quantity is not available! '.' Quantity '.$product->quantity);
        }else{
            try {
                $this->count++;
                $this->dispatch('count');
                $this->alertSuccess('Product quantity updated Successfully');
            } catch (\Exception $e) {
                $this->alertDelete('some thing went wrong');
            }
        }
    }

    public function decrement()
    {
        try {
            if ($this->count < 1) {
                $this->count = 1;
            }else if($this->count > 1){
                $this->count--;
                $this->alertSuccess('Product quantity updated Successfully');
            }
            $this->dispatch('count');
        } catch (\Exception $e) {
            $this->alertDelete('some thing went wrong');
        }

    }
    #[On('count')]
    public function updated()
    {
        $selectedSizePrice = 0;
        $basePrice = $this->basePrice;
        $quantity = $this->count;
        if ($this->productSizeId > 0) {
            $model = ProductSize::select('price')->findOrFail($this->productSizeId);
            $this->selectedSizePrice = number_format($model->price, 2);
            $selectedSizePrice = $this->selectedSizePrice;
        }
        if (count($this->productOptionPriceId) > 0) {
            $selectedOptionPrice = ProductOption::whereIn('id', $this->productOptionPriceId)
                ->sum('price');
        }else{
            $selectedOptionPrice = 0;
        }
        /*
        if (count($this->productOptionPriceId) > 0) {
            $selectedOptionPrice = ProductOption::whereIn('id', $this->productOptionPriceId)   //stackoverflow solution
                ->selectRaw('sum(case when `price` - truncate(`price`, 2) > 0.004 then round(`price`, 2) else truncate(`price`, 2) end) as total')
                ->first()['total'] ?? 0;
        }else{
            $selectedOptionPrice = 0;
        }
       */
        $this->totalPrice = ($basePrice + $selectedSizePrice + $selectedOptionPrice) * $quantity;

        $this->dispatch('totalPrice' , ['basePrice' => $basePrice,'selectedSizePrice' => $selectedSizePrice,'selectedOptionPrice' => $selectedOptionPrice,'quantity' => $quantity]);
    }
    public function addCart()
    {
        try {
            $product = Product::with(['productSizes', 'productOptions'])->findOrFail($this->product_id);
            $productSize = $product->productSizes->where('id', $this->productSizeId)->first();
            $productOption = $product->productOptions->whereIn('id', $this->productOptionPriceId);

            $options = [
                'productSize' => [],
                'productOptions' => [],
                'productInfo' => [
                    'image' => $product->thumb_image,
                    'slug' => $product->slug,
                ]
            ];
            if ($productSize !== null) {
                $options['productSize'] = [
                    'id' => $productSize->id,
                    'name' => $productSize->name,
                    'price' => $productSize->price
                ];
            }
            foreach ($productOption as $productOptions) {
                $options['productOptions'][] = [
                    'id' => $productOptions->id,
                    'name' => $productOptions->name,
                    'price' => $productOptions->price
                ];
            }
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $this->count,
                'price' => $this->basePrice,
                'weight' => 0,
                'options' => $options

            ]);
            session()->forget('coupon');
            $this->dispatch('addCart');
            $this->alertSuccess('Product added to cart Successfully');

        }catch (\Exception $e) {
            $this->alertDelete('some thing went wrong');
        }
    }
    function productReviewStore() {
        $this->validate([
            'rating' => ['required', 'min:1', 'max:5', 'integer'],
            'review' => ['required', 'max:500'],
            'product_id' => ['required', 'integer']
        ]);

        $user = Auth::user();

        $hasPurchased = $user->orders()->whereHas('orderItems', function($query){
            $query->where('product_id', $this->product_id);
        })
            ->where('order_status', 'delivered')
            ->get();


        if(count($hasPurchased) == 0){
            $this->alertDelete('Please Buy The Product Before Submit a Review');
            throw ValidationException::withMessages(['Please Buy The Product Before Submit a Review!']);
        }

        $alreadyReviewed = ProductRating::where(['user_id' => $user->id, 'product_id' => $this->product_id])->exists();
        if($alreadyReviewed){
            $this->alertDelete('You already reviewed this product');
            throw ValidationException::withMessages(['You already reviewed this product']);
        }

        $review = new ProductRating();
        $review->user_id = $user->id;
        $review->product_id = $this->product_id;
        $review->rating = $this->rating;
        $review->review = $this->review;
        $review->status = 0;
        $review->save();

        $this->alertSuccess('Review added successfully and waiting to approve');

        return redirect()->back();
    }
    function WishList() {

        @$productAlreadyExist = Wishlist::where(['user_id' => auth()->user()->id, 'product_id' => $this->product_id])->exists();
        if(!Auth::check()){
            $this->alertDelete('Please login for add product in wishlist');
            throw ValidationException::withMessages(['Please login for add product in wishlist']);
        }
        if($productAlreadyExist){
            $this->alertDelete('Product is already add to wishlist');
            throw ValidationException::withMessages(['Product is already add to wishlist ']);
        }
        $wishlist = new Wishlist();
        $wishlist->user_id = auth()->user()->id;
        $wishlist->product_id = $this->product_id;
        $wishlist->save();
        $this->alertSuccess('Product added to wishlist');
        return response(['status' => 'success', 'message' => 'Product added to wishlist!']);
    }
}
