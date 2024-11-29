<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductSize;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class ProductVariant extends Component
{
    public $saved = false;
    public $product;
    public $model_id,$product_id;
    public $sname,$sprice;
    public $oname,$oprice;
    public $paginate = 10;
    public $search = "";
    public $sections = null;

    protected $listeners = ['deleteConfirmed'=>'delete'];

    public function mount($id)
    {
        $product = Product::findOrFail($id);
        $this->product = $product;
        $this->product_id = $product->id;
    }
    public function render()
    {
        $sizes = ProductSize::where('product_id', $this->product_id)->get();
        $options = ProductOption::where('product_id', $this->product_id)->get();
        return view('livewire.admin.products.product-variant',[
            'sizes' => $sizes,
            'options' => $options,
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
    public function SaveSize()
    {
        $this->validate([
            'product_id' => 'required',
            'sname' => 'required|max:255',
            'sprice' => 'required|numeric',

        ], [
            'sname.required' => 'name required.',
            'sprice.required' => 'price required.',
        ]);
        $size = new ProductSize();
        $size->product_id = $this->product_id;
        $size->name = $this->sname;
        $size->price = $this->sprice;
        $size->save();
        $this->alertSuccess('Product Size Inserted Successfully');
    }
    public function destroyProductSize($id)
    {
        try{
            $size = ProductSize::findOrFail($id);
            $size->delete();
            $this->alertSuccess('Product Size Deleted Successfully');
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
    public function SaveOption()
    {
        $this->validate([
            'product_id' => 'required',
            'oname' => 'required|max:255',
            'oprice' => 'required|numeric',

        ], [
            'oname.required' => 'name required.',
            'oprice.required' => 'price required.',
        ]);
        $option = new ProductOption();
        $option->product_id = $this->product_id;
        $option->name = $this->oname;
        $option->price = $this->oprice;
        $option->save();
        $this->alertSuccess('Product Options Inserted Successfully');
    }
    public function destroyProductOption($id)
    {
        try{
            $option = ProductOption::findOrFail($id);
            $option->delete();
            $this->alertSuccess('Product Option Deleted Successfully');
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
