<?php

namespace App\Livewire\Home\DashBoard\Sections;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.home.master')]
class WishlistSection extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $wishlist = Wishlist::with(['product'])->where('user_id', auth()->user()->id)->latest()->paginate(15);
        return view('livewire.home.dash-board.sections.wishlist-section', compact('wishlist'));
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
}
