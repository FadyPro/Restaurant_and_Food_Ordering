<?php

namespace App\Livewire\Admin\Counter;

use App\Models\Counter;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin.master')]
class CounterCreate extends Component
{
    use WithFileUploads;

    public $saved = false;
    public $background,
        $counter_icon_one,$counter_count_one,$counter_name_one,
        $counter_icon_two,$counter_count_two,$counter_name_two,
        $counter_icon_three,$counter_count_three,$counter_name_three,
        $counter_icon_four,$counter_count_four,$counter_name_four;
    public $counter;
    public function mount()
    {
        $model = Counter::findOrFail(1);
        $this->counter = $model;
        $this->counter_icon_one = $model->counter_icon_one;
        $this->counter_count_one = $model->counter_count_one;
        $this->counter_name_one = $model->counter_name_one;
        $this->counter_icon_two = $model->counter_icon_two;
        $this->counter_count_two = $model->counter_count_two;
        $this->counter_name_two = $model->counter_name_two;
        $this->counter_icon_three = $model->counter_icon_three;
        $this->counter_count_three = $model->counter_count_three;
        $this->counter_name_three = $model->counter_name_three;
        $this->counter_icon_four = $model->counter_icon_four;
        $this->counter_count_four = $model->counter_count_four;
        $this->counter_name_four = $model->counter_name_four;
    }
    public function render()
    {
        return view('livewire.admin.counter.counter-create');
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
            'background' => ['nullable', 'image'],

            'counter_icon_one' => ['required', 'max:255'],
            'counter_count_one' => ['required', 'numeric'],
            'counter_name_one' => ['required', 'max:255'],

            'counter_icon_two' => ['required', 'max:255'],
            'counter_count_two' => ['required', 'numeric'],
            'counter_name_two' => ['required', 'max:255'],

            'counter_icon_three' => ['required', 'max:255'],
            'counter_count_three' => ['required', 'numeric'],
            'counter_name_three' => ['required', 'max:255'],

            'counter_icon_four' => ['required', 'max:255'],
            'counter_count_four' => ['required', 'numeric'],
            'counter_name_four' => ['required', 'max:255'],

        ],[
            'background.image' => 'The Background must be an image',

            'counter_icon_one.required' => 'The Counter Icon One field is required.',
            'counter_count_one.required' => 'The Counter Count One field is required.',
            'counter_name_one.required' => 'The Counter Name One field is required.',

            'counter_icon_two.required' => 'The Counter Icon Two field is required.',
            'counter_count_two.required' => 'The Counter Count Two field is required.',
            'counter_name_two.required' => 'The Counter Name Two field is required.',

            'counter_icon_three.required' => 'The Counter Icon Three field is required.',
            'counter_count_three.required' => 'The Counter Count Three field is required.',
            'counter_name_three.required' => 'The Counter Name Three field is required.',

            'counter_icon_four.required' => 'The Counter Icon Four field is required.',
            'counter_count_four.required' => 'The Counter Count Four field is required.',
            'counter_name_four.required' => 'The Counter Name Four field is required.',

        ]);

        $imageName = uniqid() . '-' . time() . '.' . $this->background->extension();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->background);
        $image->resize(5472,1026)->toJpeg()->save(public_path('\uploads\counter/'.$imageName));

       Counter::updateOrCreate(
           ['id' => 1],
           [
               'background' => $imageName,
               'counter_icon_one' => $this->counter_icon_one,
               'counter_count_one' => $this->counter_count_one,
               'counter_name_one' => $this->counter_name_one,

               'counter_icon_two' => $this->counter_icon_two,
               'counter_count_two' => $this->counter_count_two,
               'counter_name_two' => $this->counter_name_two,

               'counter_icon_three' => $this->counter_icon_three,
               'counter_count_three' => $this->counter_count_three,
               'counter_name_three' => $this->counter_name_three,

               'counter_icon_four' => $this->counter_icon_four,
               'counter_count_four' => $this->counter_count_four,
               'counter_name_four' => $this->counter_name_four,
           ]);
        $this->alertSuccess('Counter Added Successfully');
        return redirect()->back();
    }
}
