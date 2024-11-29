<?php

namespace App\Livewire\Home\Frontend;

use App\Services\OrderService;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.home.master')]
class Payment extends Component
{
    public $payment_gateway;

    public function render()
    {
        if (!session()->has('delivery_fee') || !session()->has('address')) {
            $this->alertDelete('some thing went wrong');
            throw ValidationException::withMessages(['Something went wrong']);
        }else{
            $subtotal = cartTotal();
            $delivery = session()->get('delivery_fee') ?? 0;
            $discount = session()->get('coupon')['discount'] ?? 0;
            $grandTotal = grandCartTotal($delivery);
        }

        return view('livewire.home.frontend.payment', compact('subtotal', 'delivery', 'discount', 'grandTotal'));
    }
    public function alertSuccess($rel)
    {
        $this->dispatch('alert',
            ['types' => 'success',  'message' => $rel]);
    }
    public function alertDelete($rel)
    {
        $this->dispatch('alert',
            ['types' => 'error',  'message' => $rel]);
    }
    function makePayment($pay, OrderService $orderService)
    {
        $this->payment_gateway = $pay;

        $this->validate([
            'payment_gateway' => ['required', 'string', 'in:paypal,stripe,paymob']
        ]);

        /** Create Order */
        if ($orderService->createOrder()) {
            // redirect user to the payment host
            switch ($this->payment_gateway) {
                case 'paypal':
//                    return response(['redirect_url' => route('paypal.payment')]);
                    return redirect()->to(route('paypal.payment'));
                    break;

                case 'stripe':
//                    return response(['redirect_url' => route('stripe.payment')]);
                    return redirect()->to(route('stripe.payment'));
                    break;

                case 'paymob':
//                    return response(['redirect_url' => route('paymob.payment')]);
                    return redirect()->to(route('paymob.payment'));
                    break;

                default:
                    break;
            }
        }
    }

}
