<?php

namespace App\Livewire\Admin\BannerSlider;

use App\Models\BannerSlider;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class BannerSliderCreate extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $banner,$title,$sub_title,$url,$status;

    public function render()
    {
        return view('livewire.admin.banner-slider.banner-slider-create');
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
            'banner' => ['required', 'image', 'max:255'],
            'title' => ['required', 'max:255'],
            'sub_title' => ['required', 'max:255'],
            'url' => ['required'],
            'status' => ['required', 'boolean']
        ],[
            'banner.required' => 'jpeg,jpg,png,gif',
            'title.required' => 'Title Required',
            'sub_title.required' => 'Sub Title Required',
            'url.required' => 'Url Required',
            'status.required' => 'Status Required',
        ]);

        $imageName = uniqid() . '.' . $this->banner->extension();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->banner);
        $image->resize(400,250)->toPng()->save(public_path('\uploads\banner_slider/'.$imageName));

        $model = new BannerSlider();
        $model->banner = $imageName;
        $model->title = $this->title;
        $model->sub_title = $this->sub_title;
        $model->url = $this->url;
        $model->status = $this->status;
        $model->save();

        $this->alertSuccess('Banner Slider Created Successfully');
        return redirect()->to(route('admin.banner-slider.index'));
    }
}
