<?php

namespace App\Livewire\Home\Components;

use App\Models\DailyOffer;
use App\Models\SectionTitles;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class OfferItem extends Component
{
    public $isOpen = 0;
    public $selectId;

    public function render()
    {
        $sectionTitles = $this->getSectionTitles();
        $dailyOffers = DailyOffer::with('product')->where('status', 1)->take(15)->get();
        return view('livewire.home.components.offer-item', compact('dailyOffers', 'sectionTitles'));
    }
     function getSectionTitles() {
        $keys = [
            'why_choose_top_title',
            'why_choose_main_title',
            'why_choose_sub_title',
            'daily_offer_top_title',
            'daily_offer_main_title',
            'daily_offer_sub_title',
            'chef_top_title',
            'chef_main_title',
            'chef_sub_title',
            'testimonial_top_title',
            'testimonial_main_title',
            'testimonial_sub_title'
        ];

        return SectionTitles::whereIn('key', $keys)->pluck('value','key');
    }
    public function openModal($id)
    {
        dd($id);
        $this->selectId = $id;
        $this->isOpen = true;
        $this->dispatch('showModal');
//        $this->dispatch('openModal', ['selectId' => $this->selectId]);
    }
//    #[On('hideModal')]
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
