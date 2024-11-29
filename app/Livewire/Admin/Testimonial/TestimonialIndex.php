<?php

namespace App\Livewire\Admin\Testimonial;

use App\Models\SectionTitles;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Component;
use File;

#[Layout('layouts.admin.master')]
class TestimonialIndex extends Component
{
    public $model_id;
    public $paginate = 10;
    public $search = "";
    public $sections = null;
    public $selectedSection = null;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    protected $listeners = ['deleteConfirmed'=>'delete'];
    public $testimonial_top_title,$testimonial_main_title, $testimonial_sub_title;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->testimonial_top_title = SectionTitles::where('key', 'testimonial_top_title')->first()->value;
        $this->testimonial_main_title = SectionTitles::where('key', 'testimonial_main_title')->first()->value;
        $this->testimonial_sub_title = SectionTitles::where('key', 'testimonial_sub_title')->first()->value;
    }
    public function render()
    {
        $model = Testimonial::query()
            ->where('name','like','%'.$this->search.'%')
            ->orWhere('title','like','%'.$this->search.'%')
            ->paginate($this->paginate)->withQueryString();
        return view('livewire.admin.testimonial.testimonial-index',compact('model'));
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
            $item =  Testimonial::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Coupon Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.testimonial.index'));
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
            $item =  Testimonial::findOrFail($id);
            $this->removeImage('/uploads/testimonial/'.$item->image);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.testimonial.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = Testimonial::pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
            Testimonial::whereKey($this->checked)->delete();
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
    public function updateTitles()
    {
        $validatedData = $this->validate([
            'testimonial_top_title' => ['max:100'],
            'testimonial_main_title' => ['max:200'],
            'testimonial_sub_title' => ['max:500']
        ]);

        foreach ($validatedData as $key => $value){
            SectionTitles::query()->updateOrCreate([
                'key' => $key,
                'value' => $value
            ]);
        }
        $this->alertSuccess('Titles Updated Successfully');
    }
}
