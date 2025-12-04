{{-- resources/views/dashboard/purchase_orders/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل أمر الشراء - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .section-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .section-content:hover {
            background: #e9ecef;
        }

        .po-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4361ee, #5e7bff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            font-weight: bold;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">أوامر الشراء /</span> #{{ $purchaseOrder->id }}
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">#{{ $purchaseOrder->id }} - {{ $purchaseOrder->supplier->name }}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 text-center mb-4">
                        <div class="po-avatar-large">
                            PO
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                                <div class="section-content">
                                    <h6 class="section-title">تاريخ الطلب</h6>
                                    <p>{{ $purchaseOrder->order_date->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                                <div class="section-content">
                                    <h6 class="section-title">تاريخ التسليم المتوقع</h6>
                                    <p>{{ $purchaseOrder->expected_delivery_date->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                                <div class="section-content">
                                    <h6 class="section-title">الإجمالي</h6>
                                    <p>{{ number_format($purchaseOrder->total_amount, 2) }} {{ settings('currency') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                                <div class="section-content">
                                    <h6 class="section-title">الحالة</h6>
                                    <p>{{ __($purchaseOrder->status) }}</p>
                                </div>
                            </div>
                            <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                                <div class="section-content">
                                    <h6 class="section-title">الملاحظات</h6>
                                    <p>{{ $purchaseOrder->notes ?? 'لا توجد ملاحظات' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4">المنتجات</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>المجموع الفرعي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrder->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>{{ number_format($product->pivot->price, 2) }}</td>
                                <td>{{ number_format($product->pivot->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="mt-4">إيصالات الاستلام</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>رقم GRN</th>
                            <th>تاريخ الاستلام</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrder->goodsReceivedNotes as $grn)
                            <tr>
                                <td>#{{ $grn->id }}</td>
                                <td>{{ $grn->received_date->format('Y-m-d') }}</td>
                                <td>{{ __($grn->status) }}</td>
                            </tr>
                        @endforeach
                        @if ($purchaseOrder->goodsReceivedNotes->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">لا توجد إيصالات استلام</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="action-buttons mt-4">
                    <a href="{{ route('purchase-orders.index') }}"
                        class="btn btn-secondary animate__animated animate__pulse">عودة</a>
                    @if ($purchaseOrder->status == 'pending')
                        <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}"
                            class="btn btn-primary animate__animated animate__pulse">تعديل</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
