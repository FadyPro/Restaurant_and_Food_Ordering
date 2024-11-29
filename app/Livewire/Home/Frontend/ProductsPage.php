<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.home.master')]
class ProductsPage extends Component
{
    #[Url]
    public $search,$category;

    public $selectId;
    public $isOpen = 0;

    public function render()
    {
        $products = Product::where(['status' => 1])->orderBy('id', 'DESC');

        if($this->search) {
            $products->where(function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('long_description', 'like', '%'.$this->search.'%');
            });
        }

        if($this->category) {
            $products->whereHas('category', function($query){
                $query->where('slug', $this->category);
            });
        }

        $products = $products->withAvg('reviews', 'rating')->withCount('reviews')->paginate(12);

        $categories = Category::where('status', 1)->get();
        return view('livewire.home.frontend.products-page',compact('products', 'categories'));
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
