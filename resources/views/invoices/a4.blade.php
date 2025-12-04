<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم {{ settings('invoice_prefix', 'INV-') }}1024</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f9f9f9;
            color: #333;
        }

        .invoice {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #4361ee, #5e7bff);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header img {
            height: 80px;
            border-radius: 16px;
            border: 4px solid white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .header h1 {
            margin: 15px 0 5px;
            font-size: 2.2rem;
            font-weight: 800;
        }

        .info {
            padding: 30px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            background: #f8f9ff;
        }

        .info div {
            flex: 1;
            min-width: 250px;
            margin: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #4361ee;
            color: white;
            font-weight: 600;
        }

        .total {
            background: #4361ee;
            color: white;
            font-size: 1.4rem;
            font-weight: bold;
        }

        .footer {
            background: #1e293b;
            color: white;
            padding: 30px;
            text-align: center;
            font-size: 0.9rem;
        }

        .badge {
            background: #10b981;
            color: white;
            padding: 2px 5px;
            font-size: 12px;
            border-radius: 50px;
            font-weight: bold;
        }

        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="header">
            @if (settings('logo'))
                <img src="{{ asset('storage/' . settings('logo')) }}" alt="Logo">
            @else
                <h1>زهور</h1>
            @endif
            <h1>{{ settings('system_name', 'متجر زهور') }}</h1>
            <p>فاتورة رسمية</p>
        </div>

        <div class="info">
            <div>
                <strong>رقم الفاتورة:</strong> {{ settings('invoice_prefix', 'INV-') }}1024<br>
                <strong>التاريخ:</strong> 15 مارس 2025 - 04:35 PM<br>
                <strong>الفرع:</strong> الفرع الرئيسي
            </div>
            <div style="text-align: left;">
                <strong>العميل:</strong> أحمد محمد<br>
                <strong>رقم الجوال:</strong> 01012345678<br>
                <strong>طريقة الدفع:</strong> <span class="badge">كاش</span>
            </div>
        </div>

        <table>
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

                <tr>
                    <td>1</td>
                    <td>ورد طبيعي</td>
                    <td>2</td>
                    <td>150.00 {{ settings('currency', 'ج.م') }}</td>
                    <td>300.00 {{ settings('currency', 'ج.م') }}</td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>بوكيه هدايا</td>
                    <td>1</td>
                    <td>200.00 {{ settings('currency', 'ج.م') }}</td>
                    <td>200.00 {{ settings('currency', 'ج.م') }}</td>
                </tr>

                <tr>
                    <td colspan="4" class="total">الإجمالي قبل الضريبة</td>
                    <td class="total">500.00 {{ settings('currency') }}</td>
                </tr>

                @if (settings('vat_rate') > 0)
                    <tr>
                        <td colspan="4">ضريبة القيمة المضافة ({{ settings('vat_rate') }}%)</td>
                        <td>70.00 {{ settings('currency') }}</td>
                    </tr>
                @endif

                <tr>
                    <td colspan="4" style="background:#10b981; color:white; font-size:1.5rem;">
                        الإجمالي النهائي
                    </td>
                    <td style="background:#10b981; color:white; font-size:1.5rem;">
                        570.00 {{ settings('currency') }}
                    </td>
                </tr>

            </tbody>
        </table>

        <div class="footer">
            <p>شكرًا لتسوقك معنا</p>
            <p>
                للاستفسار: {{ settings('support_phone', '01000000000') }} |
                {{ settings('support_email', 'support@flowers.com') }}
            </p>
        </div>
    </div>

    <div class="no-print text-center mt-5">
        <button onclick="window.print()" class="btn btn-success btn-lg">طباعة الفاتورة</button>
    </div>
</body>

</html>
