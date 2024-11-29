<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        table th{
            text-align: left;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
        .font{
            font-size: 15px;
        }
        .authority {
            /*text-align: center;*/
            float: right
        }
        .authority h5 {
            margin-top: -10px;
            color: green;
            /*text-align: center;*/
            margin-left: 35px;
        }
        .thanks p {
            color: green;;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
    </style>

</head>
<body>

<table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
    <tr>
        <td valign="top">
            <!-- {{-- <img src="" alt="" width="150"/> --}} -->
            <h2 style="color: green; font-size: 26px;"><strong>Food</strong></h2>
        </td>
        <td align="right">
            <pre class="font" >
               EasyShop Head Office
               Email:support@invoice.com <br>
               Mob: 1111222255 <br>
               100254 Barnes Street,United States <br>
            </pre>
        </td>
    </tr>

</table>

<br>
<table width="100%" style="background:white; padding:2px;">
    <tr>
        <td valign="top">
            <strong>Deliver To:</strong><br>
            <strong>Name:</strong> {!! @$order->userAddress->first_name !!} {!! @$order->userAddress->last_name !!}
            <br>
            <strong>Phone:</strong> {!! @$order->userAddress->phone !!}
            <br>
            <strong>Address:</strong> {!! @$order->userAddress->address !!}
            <br>
            <strong>Aria:</strong> {!! @$order->userAddress->deliveryArea->area_name !!}
            <br>
            <strong>Payment Method:</strong><br>
            {{ $order->payment_method }}<br>
            <strong>Payment Status: </strong>
            @if(strtoupper($order->payment_status) == 'COMPLETED')
                <span style="color: green">COMPLETED</span>
            @elseif(strtoupper($order->payment_status) == 'PENDING')
                <span style="color: orange">PENDING</span>
            @else
                <span style="color: red">{{ $order->payment_status }}</span>
            @endif

        </td>
        <td align="right">
            <h2>Invoice</h2>
            <div class="invoice-number">Order #{{ $order->invoice_id }}</div>
            <br>
            <strong>Order Date:</strong><br>
            {{ date('F d, Y / H:i', strtotime($order->created_at)) }}
            <br><br>
            <strong>Order Status:</strong><br>
            @if($order->order_status === 'delivered')
                <span style="color: green">Delivered</span>
            @elseif($order->order_status === 'declined')
                <span style="color: red">Declined</span>
            @else
                <span style="color: orange">{{ $order->order_status }}</span>
            @endif
            <br><br>
        </td>
    </tr>
</table>

<table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">

    <thead class="table-light">
    <tr>
        <th>#</th>
        <th>Item</th>
        <th>Size & Optional</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Totals</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($order->orderItems as $orderItem)
        @php
            $size = json_decode($orderItem->product_size);
            $options = json_decode($orderItem->product_option);
            $qty = $orderItem->qty;
            $untiPrice = $orderItem->unit_price;
            $sizePrice = $size->price;
            $optionPrice = 0;
            foreach ($options as $optionItem) {
                $optionPrice += $optionItem->price;
            }
            $productTotal = ($untiPrice + $sizePrice + $optionPrice) * $qty;
        @endphp
        <tr>
            <td>{{ ++$loop->index }}</td>
            <td>{{ $orderItem->product_name }}</td>
            <td>
                <b>{{ @$size->name }} ({{ currencyPosition(@$size->price) }})</b>
                <br>
                options:
                <br>
                @foreach ($options as $option)
                    {{ @$option->name }} ({{ currencyPosition(@$option->price) }})
                    <br>
                @endforeach
            </td>

            <td class="text-center">{{ currencyPosition($orderItem->unit_price) }}</td>
            <td class="text-center">{{ $orderItem->qty }}</td>
            <td class="text-right">{{ currencyPosition($productTotal) }}</td>
        </tr>
    @endforeach


    </tbody>

</table>
<br/>

<table class="table test_table" style="float: right" border="none">
    <tr>
        <td>Subtotal</td>
        <td>{{ currencyPosition($order->subtotal) }}</td>
    </tr>
    <tr>
        <td>Shipping</td>
        <td>{{ currencyPosition($order->delivery_charge) }}</td>
    </tr>
    <tr>
        <td>Discount</td>
        <td>{{ currencyPosition($order->discount) }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold">Total</td>
        <td style="font-weight: bold">{{ currencyPosition($order->grand_total) }}</td>
    </tr>
</table>





<table class="table test_table" style="float:right; border:none">

</table>


<div class="thanks mt-3">
    <p>Thanks For Your Ordering..!!</p>
</div>

</body>
</html>
