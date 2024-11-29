<?php

namespace App\Livewire\Home\Components;

use App\Models\Blog;
use Livewire\Component;

class BlogHome extends Component
{
    public function render()
    {
        $latestBlogs = Blog::withCount(['comments' => function($query){
            $query->where('status', 1);
        }])->with(['category', 'user'])->where('status', 1)->latest()->take(3)->get();

        return view('livewire.home.components.blog-home', compact('latestBlogs'));
    }
}
