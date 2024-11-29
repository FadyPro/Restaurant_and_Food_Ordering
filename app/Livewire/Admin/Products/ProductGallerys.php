<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\ProductGallery;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class ProductGallerys extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $image = [];
    public $photo;
    public $Product;
    public $model_id,$product_id;
    public $paginate = 10;
    public $search = "";
    public $sections = null;
    public $selectedSection = null;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    protected $listeners = ['deleteConfirmed'=>'delete'];

    public function mount($id)
    {
        $Product = Product::findOrFail($id);
        $this->Product = $Product;
        $this->product_id = $Product->id;
    }
    public function render()
    {
        $model = ProductGallery::query()->where('product_id',$this->product_id)->paginate($this->paginate);
        return view('livewire.admin.products.product-gallerys',
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
    public function save()
    {
        $this->validate([
            'product_id' => 'required',
            'image.*' => 'required|image|max:420|mimes:jpeg,jpg,png,gif',
        ], [
            'product_id.required' => 'jpeg,jpg,png,gif required.',
            'image.*.required' => 'jpeg,jpg,png,gif.',
            'image.*.max' => 'image should be less than420 MB.',
        ]);

            foreach ($this->image as $key => $file)
            {
                $imageName = uniqid() . '.' . $file->extension();
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);
                $image->resize(550,300)->toJpeg()->save(public_path('\uploads\products/'.$imageName));
//                $imagesM = uniqid() . '.' . $file->extension();
//                $file->storeAs('uploads/products', $imagesM,'public_upload');
                ProductGallery::insert([
                    'product_id' => $this->product_id,
                    'image' => $imageName,
                ]);
            }

        $this->alertSuccess('Images Inserted Successfully');
    }
    public function deleteConfirmation($id)
    {
        $this->model_id = $id;
        $this->dispatch('show-delete-confirm');
    }
    public function delete()
    {
        try{
            $item =  ProductGallery::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Image Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to('admin/product/ImageGallery/'.$this->product_id);
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
    public function deleteOne($id)
    {
        try{
            $item =  ProductGallery::findOrFail($id);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to('admin/product/ImageGallery/'.$this->product_id);
        }catch(\Exception $e){
//            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = ProductGallery::pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
            ProductGallery::whereKey($this->checked)->delete();
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
