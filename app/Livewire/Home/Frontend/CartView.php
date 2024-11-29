<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductSize;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.home.master')]
class CartView extends Component
{
    public $cartTotal,$code,$finalTotal,$discount;


    public function mount()
    {
        $this->cartTotal = $this->updatedCartTotal();
    }
    public function render()
    {
        return view('livewire.home.frontend.cart-view');
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
    #[On('addCart')]
    public function updatedCartTotal()
    {
        $total = 0;
        foreach (Cart::content() as $item) {
            $productPrice = $item->price;
            $sizePrice = $item->options?->productSize['price'] ?? 0;
            $optionsPrice = 0;
            foreach ($item->options->productOptions as $option) {
                $optionsPrice += $option['price'];
            }

            $total += ($productPrice + $sizePrice + $optionsPrice) * $item->qty;
        }
        $this->cartTotal = $total;
        return $total;
    }
    public function increment($rowId)
    {
        $cartData = Cart::content()->where('rowId', $rowId)->first();
        $product = Product::select('quantity')->findOrFail($cartData->id);
        if($product->quantity <= $cartData->qty){
            $this->alertDelete('Quantity is not available! '.' Quantity '.$product->quantity);
        }else{
            try {
                $cartData = Cart::content()->where('rowId', $rowId)->first();
                if ($cartData) {
                    $cartData->qty++;
                    $this->updatedCartTotal();
                    $this->ProductTotal($rowId);
//                    $this->dispatch('count');
                    $this->dispatch('addCart');
                    $this->alertSuccess('Product quantity updated Successfully');
                }
            } catch (\Exception $e) {
                $this->alertDelete('some thing went wrong');
            }
        }
    }

    public function decrement($rowId)
    {
        try {
            $cartData = Cart::content()->where('rowId', $rowId)->first();
            if ($cartData) {
                if ($cartData->qty < 1) {
                    $cartData->qty = 1;
                }else if($cartData->qty > 1){
                    $cartData->qty--;
                    $this->updatedCartTotal();
                    $this->ProductTotal($rowId);
                    $this->dispatch('addCart');
                    $this->alertSuccess('Product quantity updated Successfully');
                }
//                $this->dispatch('count');

            }
        } catch (\Exception $e) {
            $this->alertDelete('some thing went wrong');
        }

    }

    function ProductTotal($rowId)
    {
        $total = 0;

        $product = Cart::get($rowId);

        $productPrice = $product->price;
        $sizePrice = $product->options?->productSize['price'] ?? 0;
        $optionsPrice = 0;

        foreach ($product->options->productOptions as $option) {
            $optionsPrice += $option['price'];
        }

        $total += ($productPrice + $sizePrice + $optionsPrice) * $product->qty;

        return $total;
    }

    public function removeProductFromCartView($rowId)
    {
        try {
            Cart::remove($rowId);
            $this->updatedCartTotal();
            $this->dispatch('addCart');
            $this->alertSuccess('Product Removed From cart Successfully');
        } catch (\Exception $e) {
            $this->alertDelete('some thing went wrong');
        }

    }
    public function clearAllCart()
    {
        try {
            Cart::destroy();
            session()->forget('coupon');
            $this->updatedCartTotal();
            $this->dispatch('addCart');
            $this->alertSuccess('All Product Removed From cart Successfully');
        } catch (\Exception $e) {
            $this->alertDelete('some thing went wrong');
        }
    }

    #[On('addCart')]
    function applyCoupon() {

        $subtotal = $this->cartTotal;
        $code = $this->code;

        $coupon = Coupon::where('code', $code)->where('status', 1)->first();


        if($coupon == null){
            $this->alertDelete('Invalid Coupon Code.');
        }
        elseif($coupon->quantity <= 0){
            $this->alertDelete('Coupon has been fully redeemed.');
        }
        elseif($coupon->expire_date < now()){
            $this->alertDelete('Coupon hs expired.');
        }else{
            if($coupon->discount_type === 'percent') {
                $discount = number_format($subtotal * ($coupon->discount / 100), 2);
            }elseif ($coupon->discount_type === 'amount'){
                $discount = number_format($coupon->discount, 2);
            }
            $this->finalTotal = $subtotal - $discount;

            session()->put('coupon', ['code' => $code, 'discount' => $discount]);
            $this->alertSuccess('Coupon Applied Successfully.');

            // TO CHANG THE QUANTITY OF COUPON TABLE
            $coupon->quantity--;
            $coupon->save();
            return response(['message' => 'Coupon Applied Successfully.', 'discount' => $discount, 'finalTotal' => $this->finalTotal, 'coupon_code' => $code]);
        }


    }

    function destroyCoupon() {
        try{
            session()->forget('coupon');
            return response(['message' => 'Coupon Removed!', 'grand_cart_total' => grandCartTotal()]);
        }catch(\Exception $e){
            logger($e);
            return response(['message' => 'Something went wrong']);

        }
    }


}
