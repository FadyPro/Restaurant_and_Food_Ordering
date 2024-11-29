<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Blog;
use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.home.master')]
class Blogs extends Component
{
    #[Url]
    public $search,$category;


    public function render()
    {
        $blogs = Blog::query()->withCount(['comments'=> function($query){
            $query->where('status', 1);
        }])->with(['category', 'user'])->where('status', 1);

        if($this->search){
            $blogs->where(function($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        }
        if($this->category) {
            $blogs->whereHas('category', function($query){
                $query->where('slug', $this->category);
            });
        }

        $blogs = $blogs->latest()->paginate(9)->withQueryString();

        $categories = BlogCategory::where('status', 1)->get();

        return view('livewire.home.frontend.blogs', compact('blogs','categories'));
    }
}
