<?php

namespace App\Livewire\Admin\DailyOffer;

use App\Models\DailyOffer;
use App\Models\SectionTitles;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.master')]
class DailyOfferIndex extends Component
{
    public $model_id;
    public $daily_offer_top_title,$daily_offer_main_title,$daily_offer_sub_title;
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
        $this->daily_offer_top_title = SectionTitles::where('key', 'daily_offer_top_title')->first()->value;
        $this->daily_offer_main_title = SectionTitles::where('key', 'daily_offer_main_title')->first()->value;
        $this->daily_offer_sub_title = SectionTitles::where('key', 'daily_offer_sub_title')->first()->value;
    }
    public function render()
    {
        $model = DailyOffer::with(['product'])->whereHas('product',function ($q){
            $q->where('name','like','%'.$this->search.'%');
        })->paginate($this->paginate)->withQueryString();
        return view('livewire.admin.daily-offer.daily-offer-index', compact('model'));
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
            $item =  DailyOffer::findOrFail($this->model_id);
            $item->delete();
            $this->checked = array_diff($this->checked, [$this->model_id]);
            $this->alertSuccess('Coupon Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.daily-offer.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
    public function deleteOne($id)
    {
        try{
            $item =  DailyOffer::findOrFail($id);
            $item->delete();
            $this->alertSuccess('Deleted Successfully');
            $this->dispatch('delete-model');
            return redirect()->to(route('admin.daily-offer.index'));
        }catch(\Exception $e){
            $this->alertDelete('something went wrong!');
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }

    }
    public function updatedSelectAll($value)
    {
        if ($value)
        {
            $this->checked = DailyOffer::pluck('id')->map(fn ($item) => (string) $item)->toArray();
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
            DailyOffer::whereKey($this->checked)->delete();
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
            'daily_offer_top_title' => ['max:100'],
            'daily_offer_main_title' => ['max:200'],
            'daily_offer_sub_title' => ['max:500']
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
