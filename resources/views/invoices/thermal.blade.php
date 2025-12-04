<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة {{ $order->order_number }}</title>
    <style>
        body { font-family: monospace; margin: 0; padding: 10px; width: 80mm; font-size: 12px; line-height: 1.4; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
        .bold { font-weight: bold; }
        .large { font-size: 14px; }
        .mb-10 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 3px 0; }
        .total { font-size: 16px; font-weight: bold; }
        @media print { body { width: 80mm; } }
    </style>
</head>
<body>
<div class="text-center mb-10">
    @if(settings('logo'))
        <img src="{{ asset('storage/'.settings('logo')) }}" width="60" style="margin-bottom: 10px;">
    @endif
    <div class="large bold">{{ settings('system_name') }}</div>
    <div>{{ $order->branch?->name ?? 'الفرع الرئيسي' }}</div>
</div>

<div class="line"></div>

<div>رقم الفاتورة: {{ $order->order_number }}</div>
<div>التاريخ: {{ $order->created_at->format('d/m/Y h:i A') }}</div>
<div>الكاشير: {{ $order->user->name }}</div>

<div class="line"></div>

<table>
    <thead>
        <tr>
            <th class="text-right">المنتج</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>الإجمالي</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td class="text-right">{{ $item->product->name }}</td>
            <td class="text-center">{{ $item->quantity }}</td>
            <td>{{ number_format($item->price_at_sale, 2) }}</td>
            <td>{{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="line"></div>

<div>الإجمالي: {{ number_format($order->subtotal, 2) }} {{ settings('currency') }}</div>
@if($order->tax > 0)
<div>الضريبة: {{ number_format($order->tax, 2) }} {{ settings('currency') }}</div>
@endif
<div class="total">النهائي: {{ number_format($order->total, 2) }} {{ settings('currency') }}</div>

<div class="line"></div>

<div class="text-center">
    <div>شكرًا لزيارتكم</div>
    <div>{{ settings('support_phone') }}</div>
</div>

<script>
    window.onload = function() { window.print(); }
</script>
</body>
</html>