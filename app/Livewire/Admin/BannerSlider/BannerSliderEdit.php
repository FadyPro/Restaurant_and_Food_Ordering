<?php

namespace App\Livewire\Admin\BannerSlider;

use App\Models\BannerSlider;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class BannerSliderEdit extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $banner,$title,$sub_title,$url,$status;
    public $model_id,$BannerSlider;

    public function mount($id)
    {
        $model = BannerSlider::query()->findOrFail($id);
        $this->BannerSlider = $model;
        $this->model_id = $id;
        $this->title = $model->title;
        $this->sub_title = $model->sub_title;
        $this->url = $model->url;
        $this->status = $model->status;
    }
    public function render()
    {
        return view('livewire.admin.banner-slider.banner-slider-edit');
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
            'banner' => ['nullable', 'image', 'max:255'],
            'title' => ['required', 'max:255'],
            'sub_title' => ['required', 'max:255'],
            'url' => ['required'],
            'status' => ['required', 'boolean']
        ],[
            'banner.nullable' => 'jpeg,jpg,png,gif',
            'title.required' => 'Title Required',
            'sub_title.required' => 'Sub Title Required',
            'url.required' => 'Url Required',
            'status.required' => 'Status Required',
        ]);

        if($this->banner){
            @unlink(public_path('/uploads/banner_slider/'.$this->banner));
            $imageName = uniqid() . '.' . $this->banner->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->banner);
            $image->resize(400,250)->toPng()->save(public_path('\uploads\banner_slider/'.$imageName));
//            $this->avatar->storeAs('uploads/admin_image', $imageName,'public_upload');
        }
        if ($this->banner)
        {
            $this->BannerSlider->update([
                'title' => $this->title,
                'sub_title' => $this->sub_title,
                'url' => $this->url,
                'status' => $this->status,
                'banner' => $imageName
            ]);
        }else{
            $this->BannerSlider->update([
                'title' => $this->title,
                'sub_title' => $this->sub_title,
                'url' => $this->url,
                'status' => $this->status
            ]);
        }
        $this->saved = true;
        $this->alertSuccess('Banner Slider Updated Successfully');
        return redirect()->to(route('admin.banner-slider.index'));
    }
}
