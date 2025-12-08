<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $order->order_number }}</title>
    <style>
        body { 
            font-family: monospace, 'DejaVu Sans'; 
            margin: 0; 
            padding: 10px; 
            width: 78mm; 
            font-size: 12px; 
            line-height: 1.4; 
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .large { font-size: 15px; }
        .line { border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 3px 0; }
        .total { font-size: 16px; font-weight: bold; }
        @page { size: 80mm auto; margin: 0; }
        @media print { body { width: 78mm; padding: 5px; } }
    </style>
</head>
<body>
    <div class="text-center">
        @if(settings('logo'))
            <img src="{{ asset('storage/'.settings('logo')) }}" width="60" style="margin-bottom: 5px;">
        @endif
        <div class="large bold">{{ settings('system_name', 'زهور') }}</div>
        <div>{{ $order->branch?->name ?? 'الفرع الرئيسي' }}</div>
        <div>{{ settings('support_phone') }}</div>
    </div>

    <div class="line"></div>

    <div>فاتورة: <strong>{{ $order->order_number }}</strong></div>
    <div>التاريخ: {{ $order->created_at->format('d/m/Y h:i A') }}</div>
    <div>الكاشير: {{ $order->user->name }}</div>
    <div>العميل: {{ $order->customer_name }}</div>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th class="text-right">الصنف</th>
                <th>الكم</th>
                <th>السعر</th>
                <th>الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td class="text-right">{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td>{{ number_format($item->price_at_sale, 0) }}</td>
                <td>{{ number_format($item->total, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <div>الإجمالي: <strong>{{ number_format($order->subtotal, 0) }}</strong></div>
    @if($order->tax > 0)
    <div>الضريبة: {{ number_format($order->tax, 0) }}</div>
    @endif
    <div class="total">النهائي: {{ number_format($order->total, 0) }} ج.م</div>

    <div class="line"></div>

    <div class="text-center">
        <div class="bold">شكرًا لزيارتكم</div>
        <div>نتمنى لكم يومًا سعيدًا</div>
    </div>

    <script>window.onload = () => window.print();</script>
</body>
</html>