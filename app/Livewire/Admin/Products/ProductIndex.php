<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use File;

#[Layout('layouts.admin.master')]
class ProductIndex extends Component
{
    use WithPagination;

    public $model_id;
    public $paginate = 10;
    public $search = "";
    public $sections = null;
    public $selectedSection = null;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    protected $listeners = ['deleteConfirmed'=>'delete'];

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $model = Product::query()->where('name','like','%'.$this->search.'%')->paginate($this->paginate)->withQueryString();
        return view('livewire.admin.products.product-index',
            [
                'model' => $model
            ]);
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
            $item =  Product::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Image Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.product.index'));
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
            $item =  Product::findOrFail($id);
            $this->removeImage('/uploads/products/'.$item->thumb_image);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.product.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = Product::pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
            Product::whereKey($this->checked)->delete();
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
}
