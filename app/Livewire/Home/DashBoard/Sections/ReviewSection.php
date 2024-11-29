<?php

namespace App\Livewire\Home\DashBoard\Sections;

use App\Models\ProductRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.home.master')]
class ReviewSection extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $reviews = ProductRating::with(['product'])->where('user_id', auth()->user()->id)->paginate(15);
        return view('livewire.home.dash-board.sections.review-section', compact('reviews'));
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    }
}
