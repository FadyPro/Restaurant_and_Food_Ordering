<?php

namespace App\Livewire\Home\Components;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.home.master')]
class MenuItem extends Component
{
    public $slug,$products= [];

    public $name,$show_at_home,$status,$thumb_image,$category_id,$short_description,
        $long_description,$price,$offer_price,$quantity,$sku,$seo_title,$seo_description;
    public $selectId;
    public $model_id;

    public $isOpen = 0;

    public function mount()
    {
        //
    }
    public function render()
    {
        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();
        return view('livewire.home.components.menu-item',
            [
                'categories' => $categories,
            ]);
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
