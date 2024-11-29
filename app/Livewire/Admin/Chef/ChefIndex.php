<?php

namespace App\Livewire\Admin\Chef;

use App\Models\Chef;
use App\Models\SectionTitles;
use Livewire\Attributes\Layout;
use Livewire\Component;
use File;

#[Layout('layouts.admin.master')]
class ChefIndex extends Component
{
    public $chef_top_title,$chef_main_title,$chef_sub_title;
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
    protected $listeners = ['deleteConfirmed'=>'delete'];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->chef_top_title = SectionTitles::where('key', 'chef_top_title')->first()->value;
        $this->chef_main_title = SectionTitles::where('key', 'chef_main_title')->first()->value;
        $this->chef_sub_title = SectionTitles::where('key', 'chef_sub_title')->first()->value;
    }
    public function render()
    {
        $model = Chef::query()
            ->where('name','like','%'.$this->search.'%')
            ->orWhere('title','like','%'.$this->search.'%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->paginate)->withQueryString();
        return view('livewire.admin.chef.chef-index',compact('model'));
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
            $item =  Chef::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Image Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.chefs.index'));
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
            $item =  Chef::findOrFail($id);
            $this->removeImage('/uploads/chefs/'.$item->image);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.chefs.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = Chef::pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
            Chef::whereKey($this->checked)->delete();
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
    public function updateTitles()
    {
        $validatedData = $this->validate([
            'chef_top_title' => ['max:100'],
            'chef_main_title' => ['max:200'],
            'chef_sub_title' => ['max:500']
        ]);

        foreach ($validatedData as $key => $value){
            SectionTitles::query()->updateOrCreate([
                'key' => $key,
                'value' => $value
            ]);
        }
        $this->alertSuccess('Titles Updated Successfully');
    }
}
