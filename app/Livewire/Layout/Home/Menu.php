<?php

namespace App\Livewire\Layout\Home;

use  App\Livewire\Actions\Logout;
use App\Models\Reservation;
use App\Models\ReservationTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class Menu extends Component
{
    public $name,$phone,$date,$time,$persons;
    public $isOpen = 0;

    public function render()
    {
        return view('livewire.layout.home.menu', [
            'cartTotal' => $this->cartTotal(),
            'reservationTimes' => ReservationTime::where('status', 1)->get()
        ]);
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
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
    public function removeProductFromSidebar($rowId)
    {
        try {
            Cart::remove($rowId);
            $this->cartTotal();
            $this->alertSuccess('Product Removed From cart Successfully');
        } catch (\Exception $e) {
            $this->alertDelete('some thing went wrong');
        }

    }

    #[On('addCart')]
    public function cartTotal()
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
        $this->dispatch('cartTotal', $total);
        return $total;
    }
    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = 0;
        $this->reset('name','phone','date','time','persons');
    }
    public function reservation() {
        $this->validate([
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'max:50'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'persons' => ['required', 'numeric']
        ]);

        if(!Auth::check()){
            $this->alertDelete('Please Login to Request Reservation!');
            return redirect()->route('login');
//            throw ValidationException::withMessages(['Please Login to Request Reservation']);
        }

        $reservation = new Reservation();
        $reservation->reservation_id = rand(0, 500000);
        $reservation->user_id = auth()->user()->id;
        $reservation->name = $this->name;
        $reservation->phone = $this->phone;
        $reservation->date = $this->date;
        $reservation->time = $this->time;
        $reservation->persons = $this->persons;
        $reservation->status = 'pending';
        $reservation->save();
        $this->alertSuccess('Request send successfully');
        $this->closeModal();
        return response(['status' => 'success', 'message' => 'Request send successfully']);
    }
}
