<?php

namespace App\Livewire\Admin\WhyChooseUs;

use App\Models\SectionTitles;
use App\Models\WhyChooseUs;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin.master')]
class WhyChooseUsIndex extends Component
{
    use WithPagination;

    public $why_choose_top_title, $why_choose_main_title, $why_choose_sub_title;
    public $model_id;
    public $paginate = 10;
    public $search = "";
    public $sections = null;
    public $selectedSection = null;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    protected $listeners = ['deleteConfirmed'=>'delete'];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->why_choose_top_title = SectionTitles::where('key', 'why_choose_top_title')->first()->value;
        $this->why_choose_main_title = SectionTitles::where('key', 'why_choose_main_title')->first()->value;
        $this->why_choose_sub_title = SectionTitles::where('key', 'why_choose_sub_title')->first()->value;
    }
    public function render()
    {
        $model = WhyChooseUs::query()->latest()->paginate($this->paginate);
        return view('livewire.admin.why-choose-us.why-choose-us-index',
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
    public function deleteConfirmation($id)
    {
        $this->model_id = $id;
        $this->dispatch('show-delete-confirm');
    }
    public function delete()
    {
        try{
            $item =  WhyChooseUs::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Image Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.why-choose-us.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
    public function deleteOne($id)
    {
        try{
            $item =  WhyChooseUs::findOrFail($id);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.why-choose-us.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = WhyChooseUs::pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
            WhyChooseUs::whereKey($this->checked)->delete();
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
            'why_choose_top_title' => ['max:100'],
            'why_choose_main_title' => ['max:200'],
            'why_choose_sub_title' => ['max:500']
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
