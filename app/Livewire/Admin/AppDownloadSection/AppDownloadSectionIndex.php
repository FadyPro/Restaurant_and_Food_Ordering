<?php

namespace App\Livewire\Admin\AppDownloadSection;

use App\Models\AppDownloadSection;
use App\Models\SectionTitles;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class AppDownloadSectionIndex extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $image,$background,$title,$short_description,$play_store_link,$apple_store_link;
    public $AppDownloadSection;

    public function mount()
    {
        $model = AppDownloadSection::findOrFail(1);
        $this->AppDownloadSection = $model;
        $this->title = $model->title;
        $this->short_description = $model->short_description;
        $this->play_store_link = $model->play_store_link;
        $this->apple_store_link = $model->apple_store_link;
    }
    public function render()
    {
        return view('livewire.admin.app-download-section.app-download-section-index');
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
            'background' => ['nullable', 'image'],
            'title' => ['required', 'max:255'],
            'short_description' => ['required', 'max:1000'],
            'play_store_link' => ['nullable', 'url'],
            'apple_store_link' => ['nullable', 'url'],
        ], [

            'image.image' => 'The image must be an image',
            'background.image' => 'The background must be an image',
            'title.required' => 'The title field is required',
            'short_description.required' => 'The short description field is required',
        ]);

        if ($this->image){
            $imageName = uniqid() . '.' . $this->image->extension();
            $manager = new ImageManager(new Driver());
            $image = $manager->read($this->image);
            $image->resize(600, 700)->toPng()->save(public_path('\uploads/' . $imageName));
        }
       if ($this->background){
           $backgroundName = uniqid() . '.' . $this->background->extension();
           $backgroundManager = new ImageManager(new Driver());
           $background = $backgroundManager->read($this->background);
           $background->resize(1920, 720)->toJpeg()->save(public_path('\uploads/' . $backgroundName));
       }

        AppDownloadSection::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imageName) ?  $imageName : $this->AppDownloadSection->image,
                'background' => !empty($backgroundName) ?  $backgroundName : $this->AppDownloadSection->background,
                'title' => $this->title,
                'short_description' => $this->short_description,
                'play_store_link' => $this->play_store_link,
                'apple_store_link' => $this->apple_store_link
            ]
        );

        $this->alertSuccess('App Download Created Successfully');
        return redirect()->to(route('admin.app-download.index'));
    }

}
