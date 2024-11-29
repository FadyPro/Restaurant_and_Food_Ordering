<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Blog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use File;

#[Layout('layouts.admin.master')]
class BlogIndex extends Component
{
    public $model_id;
    public $sortBy = 'created_at';
    public $sortDirection = 'asc';
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
        $model = Blog::with(['category'])->where('title','like','%'.$this->search.'%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->paginate)->withQueryString();
        return view('livewire.admin.blog.blog-index',compact('model'));
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
            $item =  Blog::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Image Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.blogs.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
    function removeImage(string $path) : void {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
    public function deleteOne($id)
    {
        try{
            $item =  Blog::findOrFail($id);
            $this->removeImage('/uploads/blog/'.$item->image);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.blogs.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = Blog::pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
            Blog::whereKey($this->checked)->delete();
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
    public function setSortBy($sortBy)
    {
        if ($this->sortDirection == 'asc')
        {
            $this->sortDirection = 'desc';
        }else{
            $this->sortDirection = 'asc';
        }
        $this->sortBy = $sortBy;
    }
}
