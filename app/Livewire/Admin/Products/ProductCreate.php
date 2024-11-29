<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class ProductCreate extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $name,$slug,$show_at_home,$status,$thumb_image,$category_id,$short_description,
        $long_description,$price,$offer_price,$quantity,$sku,$seo_title,$seo_description;

    public function render()
    {
        $categories = Category::all();
        return view('livewire.admin.products.product-create',[
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
    public function generateUniqueSlug($model, $name): string
    {
        $modelClass = "App\\Models\\$model";

        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model $model not found.");
        }

        $slug = Str::slug($name);
        $count = 2;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . $count;
            $count++;
        }

        return $slug;
    }
    public function save()
    {
        $this->validate([
            'thumb_image' => ['required', 'image', 'max:3000'],
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
            'icon.required' => 'icon Required ',
            'slug.required' => 'slug Required',
            'status.required' => 'status Required',
            'show_at_home.required' => 'show at home Required',
        ]);

        $imageName = uniqid() . '.' . $this->thumb_image->extension();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->thumb_image);
        $image->resize(550,550)->toJpeg()->save(public_path('\uploads\products/'.$imageName));

        $product = new Product();
        $product->thumb_image = $imageName;
        $product->name = $this->name;
        $product->slug = $this->generateUniqueSlug('Product', $this->name);
        $product->category_id = $this->category_id;
        $product->price = $this->price;
        $product->offer_price = $this->offer_price ?? 0;
        $product->quantity = $this->quantity;
        $product->short_description = $this->short_description;
        $product->long_description = $this->long_description;
        $product->sku = $this->sku;
        $product->seo_title = $this->seo_title;
        $product->seo_description = $this->seo_description;
        $product->show_at_home = $this->show_at_home;
        $product->status = $this->status;
        $product->save();

        $this->alertSuccess('Product Categories inserted Successfully');
        return redirect()->to(route('admin.product.index'));
    }
}
