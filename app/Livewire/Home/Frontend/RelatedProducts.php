<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.home.master')]
class RelatedProducts extends Component
{
    public $product;
    public $relatedProducts;
    public $selectId;
    public $isOpen = 0;


    public function mount($product)
    {
        $products = Product::with(['productImages', 'productSizes', 'productOptions'])->where(['id' => $product->id, 'status' => 1])
            ->firstOrFail();
        $this->product = $products;
        $relatedProducts = Product::where('category_id', $products->category_id)
            ->where('id', '!=', $products->id)->take(8)
            ->latest()->get();
        $this->relatedProducts = $relatedProducts;
    }

    public function render()
    {
        return view('livewire.home.frontend.related-products');
    }

    public function openModal($id)
    {
        $this->selectId = $id;
        $this->isOpen = true;
        $this->dispatch('showModal');
//        $this->dispatch('openModal', ['selectId' => $this->selectId]);
    }
    #[On('hideModal')]
    public function updatedIsOpen()
    {
        $this->isOpen = 0;
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
    function WishList($id) {

        @$productAlreadyExist = Wishlist::where(['user_id' => auth()->user()->id, 'product_id' => $id])->exists();
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
        $wishlist->product_id = $id;
        $wishlist->save();
        $this->alertSuccess('Product added to wishlist');
        return response(['status' => 'success', 'message' => 'Product added to wishlist!']);
    }
}
