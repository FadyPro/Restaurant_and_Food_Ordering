<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class ProductEdit extends Component
{
    use WithFileUploads;
    public $saved = false;
    public  $name,$slug,$show_at_home,$status,$thumb_image,$category_id,$short_description,
        $long_description,$price,$offer_price,$quantity,$sku,$seo_title,$seo_description;
    public $product;
    public $model_id;

    public function mount($id)
    {
        $model = Product::query()->findOrFail($id);
        $this->product = $model;
        $this->model_id = $model->id;
        $this->name = $model->name;
        $this->category_id = $model->category_id;
        $this->short_description = $model->short_description;
        $this->long_description = $model->long_description;
        $this->price = $model->price;
        $this->offer_price = $model->offer_price;
        $this->quantity = $model->quantity;
        $this->sku = $model->sku;
        $this->seo_title = $model->seo_title;
        $this->show_at_home = $model->show_at_home;
        $this->status = $model->status;
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.products.product-edit',[
            'categories' =>$categories,
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
    public function updatedPhoto()
    {
        $this->validate([
            'avatar' => 'image|max:10'
        ]);
    }
    public function save()
    {
        $this->validate([
            'thumb_image' => ['nullable', 'image', 'max:3000'],
            'name' => ['required', 'max:255'],
            'category_id' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'offer_price' => ['nullable', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'short_description' => ['required', 'max:500'],
            'long_description' => ['required'],
            'sku' => ['nullable', 'max:255'],
            'seo_title' => ['nullable', 'max:255'],
            'seo_description' => ['nullable', 'max:255'],
            'show_at_home' => ['boolean'],
            'status' => ['required','boolean'],
        ],[
            'thumb_image.image' => 'jpeg,jpg,png,gif',
            'name.required' => 'name Required',
            'sub_title.required' => 'Sub Title Required',
            'short_description.required' => 'Short Description Required',
        ]);

        if($this->thumb_image){

            @unlink(public_path('/uploads/products/'.$this->thumb_image));
            $imageName = uniqid() . '.' . $this->thumb_image->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->thumb_image);
            $image->resize(550,550)->toJpeg()->save(public_path('\uploads\products/'.$imageName));
//            $this->avatar->storeAs('uploads/admin_image', $imageName,'public_upload');
        }
        if ($this->thumb_image)
        {
            $this->product->update([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'offer_price' => $this->offer_price ?? 0,
                'quantity' => $this->quantity,
                'short_description' => $this->short_description,
                'long_description' => $this->long_description,
                'sku' => $this->sku,
                'seo_title' => $this->seo_title,
                'seo_description' => $this->seo_description,
                'show_at_home' => $this->show_at_home,
                'status' => $this->status,
                'thumb_image' => $imageName,
            ]);
        }else{
            $this->product->update([
                'name' => $this->name,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'offer_price' => $this->offer_price ?? 0,
                'quantity' => $this->quantity,
                'short_description' => $this->short_description,
                'long_description' => $this->long_description,
                'sku' => $this->sku,
                'seo_title' => $this->seo_title,
                'seo_description' => $this->seo_description,
                'show_at_home' => $this->show_at_home,
                'status' => $this->status,
            ]);
        }

        $this->saved = true;
        $this->alertSuccess('Product Successfully Updated');
        return redirect()->to(route('admin.product.index'));
    }
}
