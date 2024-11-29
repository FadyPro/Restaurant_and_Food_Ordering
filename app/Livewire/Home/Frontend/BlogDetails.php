<?php

namespace App\Livewire\Home\Frontend;

use App\Models\Blog;
use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.home.master')]
class BlogDetails extends Component
{
    public $comments, $latestBlogs, $categories, $nextBlog, $previousBlog,$blog;
    public $comment;
    public $search;

    public function mount($slug)
    {
        $blog = Blog::with(['user'])->where('slug', $slug)->where('status', 1)->firstOrFail();
        $this->blog = $blog;
        $this->latestBlogs = Blog::select('id', 'title', 'slug', 'created_at', 'image')
            ->where('status', 1)
            ->where('id', '!=', $blog->id)
            ->latest()->take(5)->get();
        $this->categories = BlogCategory::withCount(['blogs' => function($query){
            $query->where('status', 1);
        }])->where('status', 1)->get();
        $this->nextBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '>', $blog->id)->orderBy('id', 'ASC')->first();
        $this->previousBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '<', $blog->id)->orderBy('id', 'DESC')->first();
    }
    public function render()
    {
        $commentAll = $this->blog->comments()->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        return view('livewire.home.frontend.blog-details', compact('commentAll'));
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
    public function submitComment()
    {
        if (auth()->check()){
            try {
                $this->validate([
                    'comment' => ['required', 'max:500']
                ],[
                    'comment.required' => 'comment is required',
                    'comment.max' => 'comment max 500 character',
                ]);
                $this->blog->comments()->create([
                    'user_id' => auth()->user()->id,
                    'blog_id' => $this->blog->id,
                    'comment' => $this->comment
                ]);
                $this->reset('comment');
                $this->alertSuccess('comment added Successfully and waiting for approve');
            } catch (\Exception $e) {
                $this->alertDelete('some thing went wrong '.$e->getMessage());
            }
        }else{
            return redirect()->route('login');
        }
    }
    public function submitSearch()
    {
        return redirect()->route('blogs', ['search' => $this->search]);
    }
    public function category($slug)
    {
//        dd($slug);
        return redirect()->route('blogs', ['category' => $slug]);
    }
}
