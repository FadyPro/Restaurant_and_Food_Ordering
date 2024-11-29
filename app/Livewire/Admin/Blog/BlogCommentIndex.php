<?php

namespace App\Livewire\Admin\Blog;

use App\Models\BlogComment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class BlogCommentIndex extends Component
{
    public $model_id,$status;
    public $paginate = 10;
    public $search = "";
    public $sections = null;
    public $selectedSection = null;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    public $isOpen = 0;
    protected $listeners = ['deleteConfirmed'=>'delete'];

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $model = BlogComment::with(['user','blog']);
            if($this->search) {
                $model->whereHas('blog', function($query){
                    $query->where('title', 'like', '%' . $this->search . '%');
                });
            }
            if($this->search) {
                $model->orWhereHas('user', function($query){
                    $query->where('name', 'like', '%' . $this->search . '%');
                });
            }
        $model = $model->latest()->paginate($this->paginate)->withQueryString();

        return view('livewire.admin.blog.blog-comment-index', compact('model'));
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
    public function deleteConfirmation($id)
    {
        $this->model_id = $id;
        $this->dispatch('show-delete-confirm');
    }
    public function delete()
    {
        try{
            $item =  BlogComment::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Image Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.blogs-comments.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
    public function deleteOne($id)
    {
        try{
            $item =  BlogComment::findOrFail($id);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.blogs-comments.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = BlogComment::pluck('id')->map(fn ($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
        }
//        $this->selectAll = true;
    }
    public function isChecked($id)
    {
        return in_array($id, $this->checked);
    }
    public function updatedChecked()
    {
        $this->selectAll = false;
    }
    public function deleteRecords()
    {
        try{
            BlogComment::whereKey($this->checked)->delete();
            $this->checked = [];
            $this->selectAll = false;
            $this->selectPage = false;
            $this->alertSuccess('Selected Records were deleted Successfully');
            //        session()->flash('info', 'Selected Records were deleted Successfully');
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }

    public function changeStatus($id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->status = !$comment->status;
        $comment->save();
        $this->alertSuccess('Comment Status Updated Successfully');
    }
}
