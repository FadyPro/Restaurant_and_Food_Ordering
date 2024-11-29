<?php

namespace App\Livewire\Home\DashBoard\Sections;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

#[Layout('layouts.home.master')]
class OrderDetailsSection extends Component
{
    public $orders;
    public $order_id;

    public function mount($id)
    {
        $orders = Order::query()->where('user_id',Auth::user()->id)->where('id',$id)->get();
        $this->orders = $orders;
        $this->order_id = $id;
    }
    public function render()
    {
        return view('livewire.home.dash-board.sections.order-details-section');
    }
    public function pdfInvoice()
    {
        /** this way to generate pdf with livewire and Mpdf package */
        $order = Order::query()->with(['deliveryArea','orderItems','userAddress'])->findOrFail($this->order_id);
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
