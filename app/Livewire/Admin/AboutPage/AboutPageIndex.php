<?php

namespace App\Livewire\Admin\AboutPage;

use App\Models\About;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class AboutPageIndex extends Component
{
    use WithFileUploads;

    public $image,$title,$main_title,$description,$video_link;
    public $about;
    public $saved = false;

    public function mount()
    {
        $model = About::findOrFail(1);
        $this->about = $model;
        $this->title = $model->title;
        $this->main_title = $model->main_title;
        $this->description = $model->description;
        $this->video_link = $model->video_link;
    }
    public function render()
    {
        return view('livewire.admin.about-page.about-page-index');
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
            'image' => ['nullable', 'image'],
            'title' => ['required', 'max:255'],
            'main_title' => ['required', 'max:255'],
            'description' => ['required'],
            'video_link' => ['required', 'url']

        ],[
            'image.required' => 'The image field is required.',
            'title.required' => 'The title field is required.',
            'main_title.required' => 'The main title field is required.',
            'description.required' => 'The description field is required.',
            'video_link.required' => 'The video link field is required.',
        ]);
        if ($this->image)
        {
            $imageName = uniqid() . '-' . time() . '.' . $this->image->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->image);
            $image->resize(600,400)->toJpeg()->save(public_path('\uploads/'.$imageName));
        }

        About::updateOrCreate(
            ['id' => 1],
            [
                'title' => $this->title,
                'main_title' => $this->main_title,
                'description' => $this->description,
                'video_link' => $this->video_link,
                'image' => $this->image ? $imageName : $this->about->image
            ]);
        $this->alertSuccess('About Updated Successfully');
        return redirect()->back();
    }
}
