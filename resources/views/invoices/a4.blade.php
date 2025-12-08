<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم {{ $order->order_number }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap');

        body {
            font-family: 'Cairo', 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 30px;
            background: #f5f7ff;
            color: #2d3748;
            line-height: 1.6;
        }

        .invoice {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(67, 97, 238, 0.15);
        }

        .header {
            background: linear-gradient(135deg, #4361ee, #5e7bff);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #10b981, #34d399, #0dcaf0);
        }

        .logo {
            height: 100px;
            border-radius: 20px;
            border: 6px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .header h1 {
            margin: 20px 0 8px;
            font-size: 2.8rem;
            font-weight: 900;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .header p {
            margin: 0;
            font-size: 1.3rem;
            opacity: 0.95;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 40px;
            background: #f8f9ff;
        }

        .info-box {
            background: white;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-right: 6px solid #4361ee;
        }

        .info-box h3 {
            margin: 0 0 15px;
            color: #4361ee;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .info-box p {
            margin: 8px 0;
            font-size: 1.05rem;
        }

        .badge {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 40px;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .items-table th {
            background: #4361ee;
            color: white;
            padding: 20px;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .items-table td {
            padding: 18px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .items-table tr:hover {
            background: #f0f4ff;
        }

        .totals {
            margin: 40px;
            background: #f8f9ff;
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 1.2rem;
        }

        .final-total {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
            font-size: 1.8rem !important;
            font-weight: 900;
            padding: 20px;
            border-radius: 16px;
            margin-top: 20px;
        }

        .footer {
            background: #1e293b;
            color: white;
            padding: 40px;
            text-align: center;
            font-size: 1.1rem;
        }

        .footer p {
            margin: 10px 0;
            opacity: 0.9;
        }

        @media print {
            body { background: white; padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>

<body>
    <div class="invoice">
        <!-- الهيدر -->
        <div class="header">
            @if(settings('logo'))
                <img src="{{ asset('storage/' . settings('logo')) }}" alt="Logo" class="logo">
            @else
                <h1>زهور</h1>
            @endif
            <h1>{{ settings('system_name', 'متجر زهور') }}</h1>
            <p>فاتورة رسمية</p>
        </div>

        <!-- المعلومات -->
        <div class="info-grid">
            <div class="info-box">
                <h3>معلومات الفاتورة</h3>
                <p><strong>رقم الفاتورة:</strong> {{ $order->order_number }}</p>
                <p><strong>التاريخ:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                <p><strong>الوقت:</strong> {{ $order->created_at->format('h:i A') }}</p>
                <p><strong>الفرع:</strong> {{ $order->branch?->name ?? 'الفرع الرئيسي' }}</p>
                <p><strong>الكاشير:</strong> {{ $order->user->name }}</p>
            </div>
            <div class="info-box">
                <h3>معلومات العميل</h3>
                <p><strong>الاسم:</strong> {{ $order->customer_name }}</p>
                <p><strong>رقم الجوال:</strong> {{ $order->customer_phone }}</p>
                @if($order->customer_address)
                    <p><strong>العنوان:</strong> {{ $order->customer_address }}</p>
                @endif
                <p><strong>طريقة الدفع:</strong>
                    <span class="badge" style="background:#10b981;">
                        {{ $order->payment_method == 'cash' ? 'كاش' : 'فيزا' }}
                    </span>
                </p>
            </div>
        </div>

        <!-- جدول المنتجات -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>سعر الوحدة</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $item->product->name }}</strong></td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price_at_sale, 2) }}</td>
                    <td><strong>{{ number_format($item->total, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- الإجماليات -->
        <div class="totals">
            <div class="total-row"><span>الإجمالي قبل الضريبة:</span> <strong>{{ number_format($order->subtotal, 2) }} {{ settings('currency', 'ج.م') }}</strong></div>
            @if($order->tax > 0)
                <div class="total-row"><span>ضريبة القيمة المضافة ({{ settings('vat_rate', 14) }}%):</span> <strong>{{ number_format($order->tax, 2) }} {{ settings('currency') }}</strong></div>
            @endif
            @if($order->shipping > 0)
                <div class="total-row"><span>الشحن:</span> <strong>{{ number_format($order->shipping, 2) }} {{ settings('currency') }}</strong></div>
            @endif
            @if($order->discount > 0)
                <div class="total-row text-danger"><span>الخصم:</span> <strong>-{{ number_format($order->discount, 2) }} {{ settings('currency') }}</strong></div>
            @endif
            <div class="final-total text-center">
                <div>الإجمالي النهائي</div>
                <div style="font-size: 2.5rem; margin-top: 10px;">{{ number_format($order->total, 2) }} {{ settings('currency', 'ج.م') }}</div>
            </div>
        </div>

        <!-- الفوتر -->
        <div class="footer">
            <h3>شكرًا لتسوقك معنا</h3>
            <p>نتمنى لك يومًا مليئًا بالورد والسعادة</p>
            <p>
                للاستفسار: {{ settings('support_phone', '01000000000') }} |
                {{ settings('support_email', 'support@flowers.com') }}
            </p>
            @if(settings('website'))
                <p>{{ settings('website') }}</p>
            @endif
        </div>
    </div>

    <div class="no-print text-center my-5">
        <button onclick="window.print()" class="btn btn-success btn-lg px-5">
            طباعة الفاتورة
        </button>
    </div>
</body>
</html>