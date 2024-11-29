<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

#[Layout('layouts.admin.master')]
class OrderShow extends Component
{
    public $order,$model_id,$invoice_id,$address,$discount,$delivery_charge,$subtotal,$grand_total,$product_qty,$payment_method,$payment_status,$payment_approve_date;
    public $transaction_id,$coupon_info,$currency_name,$order_status,$delivery_area_id,$id;


    public function mount($id)
    {
        $model = Order::query()->with(['deliveryArea','orderItems','userAddress'])->findOrFail($id);
        $this->order = $model;
        $this->id = $model->id;
        $this->invoice_id = $model->invoice_id;
        $this->address = $model->address;
        $this->discount = $model->discount;
        $this->delivery_charge = $model->delivery_charge;
        $this->subtotal = $model->subtotal;
        $this->grand_total = $model->grand_total;
        $this->product_qty = $model->product_qty;
        $this->payment_method = $model->payment_method;
        $this->payment_status = $model->payment_status;
        $this->payment_approve_date = $model->payment_approve_date;
        $this->transaction_id = $model->transaction_id;
        $this->coupon_info = $model->coupon_info;
        $this->currency_name = $model->currency_name;
        $this->order_status = $model->order_status;
        $this->delivery_area_id = $model->delivery_area_id;

    }
    #[On('updateOrderStatus')]
    public function render()
    {
        $notification = OrderPlacedNotification::where('order_id', $this->id)->update(['seen' => 1]);
        return view('livewire.admin.orders.order-show');
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
    public function updateOrderStatus()
    {
        $model = Order::query()->findOrFail($this->id);
        $model->payment_status = $this->payment_status;
        $model->order_status = $this->order_status;
        $model->save();
        $this->dispatch('updateOrderStatus');
        $this->alertSuccess('Order Status Updated Successfully');
//        return redirect()->route('orders.index');
    }
    public function pdfInvoice()
    {
        /** this way to generate pdf with livewire and Mpdf package */
        $order = Order::query()->with(['deliveryArea','orderItems','userAddress'])->findOrFail($this->id);
        $html = view('livewire.admin.orders.order-export-pdf', ['order' => $order]);
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4'
        ]);
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        $pdf->showImageErrors = true;
        $pdf->WriteHTML($html);
        $pdf->SetDisplayMode('fullpage');
        return response()->streamDownload( function () use ($pdf) {
            $pdf->Output('invoice.pdf', Destination::DOWNLOAD);
        }, 'invoice.pdf');
    }
}
