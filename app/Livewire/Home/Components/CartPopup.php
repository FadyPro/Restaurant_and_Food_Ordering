<?php

namespace App\Livewire\Home\Components;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductSize;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Livewire;

#[Layout('layouts.home.master')]
class CartPopup extends Component
{
    public $count = 1;
    public $saved = false;
    public $qty;
    public $name, $slug, $show_at_home, $status, $thumb_image, $category_id, $short_description,
        $long_description, $price, $offer_price, $quantity, $sku, $seo_title, $seo_description, $id;
    public $product;
    public $model_id, $selectId;
    public $isOpen = 0;
    public $basePrice;
    public $productSizeId;
    public $selectedSizePrice;
    public array  $productOptionPriceId = [];
    public $totalPrice;


    public function mount($selectId)
    {
        $model = Product::with(['productSizes', 'productOptions'])->findOrFail($selectId);
        $this->product = $model;
        $this->model_id = $model->id;
        $this->name = $model->name;
        $this->category_id = $model->category_id;
        $this->short_description = $model->short_description;
        $this->long_description = $model->long_description;
        $this->price = $model->price;
        $this->offer_price = $model->offer_price;
        $this->quantity = $model->quantity;
        $this->sku = $model->sku;
        $this->seo_title = $model->seo_title;
        $this->show_at_home = $model->show_at_home;
        $this->status = $model->status;
        $this->basePrice = $model->offer_price > 0 ? $model->offer_price : $model->price;
    }

    #[On('totalPrice')]
    public function render()
    {
        return view('livewire.home.components.cart-popup');
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

    public function closeModal()
    {
        $this->selectId = null;
        $this->dispatch('hideModal', false);
        $this->isOpen = false;
//        $this->js('window.location.reload()');
    }

    public function increment()
    {
        $this->count++;
        $this->dispatch('count');
    }

    public function decrement()
    {
        if ($this->count < 1) {
            $this->count = 1;
        }else if($this->count > 1){
            $this->count--;
        }
        $this->dispatch('count');
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
        $product = Product::with(['productSizes', 'productOptions'])->findOrFail($this->selectId);
//        $this->validate([
//            'productOptionPriceId' => ['required','array'],
//        ],[
//            'productOptionPriceId.required' => 'Product Option Required',
//        ]);

        if($product->quantity < $this->count){
            $this->alertDelete('Quantity is not available! '.' Quantity '.$product->quantity);
              $this->validate([
                     'quantity' => ['gte:{$this->>quantity}'],
                     ],[
                        'quantity.gte' => 'Quantity is not available!',
                ]);
        }else{
            try {
                $product = Product::with(['productSizes', 'productOptions'])->findOrFail($this->selectId);
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
                $this->closeModal();
            }catch (\Exception $e) {
                $this->alertDelete('some thing went wrong');
            }
        }

    }


}
