{{-- resources/views/dashboard/goods_received_notes/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل إيصال الاستلام - زهور')

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

        .grn-avatar-large {
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
            <span class="text-muted fw-light">إيصالات الاستلام /</span> #{{ $goodsReceivedNote->id }}
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">#{{ $goodsReceivedNote->id }} - {{ $goodsReceivedNote->purchaseOrder->supplier->name }}
            </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 text-center mb-4">
                        <div class="grn-avatar-large">
                            GRN
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                                <div class="section-content">
                                    <h6 class="section-title">تاريخ الاستلام</h6>
                                    <p>{{ $goodsReceivedNote->received_date->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                                <div class="section-content">
                                    <h6 class="section-title">المستلم بواسطة</h6>
                                    <p>{{ $goodsReceivedNote->receivedBy->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                                <div class="section-content">
                                    <h6 class="section-title">أمر الشراء</h6>
                                    <p>#{{ $goodsReceivedNote->purchase_order_id }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                                <div class="section-content">
                                    <h6 class="section-title">الحالة</h6>
                                    <p>{{ __($goodsReceivedNote->status) }}</p>
                                </div>
                            </div>
                            <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                                <div class="section-content">
                                    <h6 class="section-title">الملاحظات</h6>
                                    <p>{{ $goodsReceivedNote->notes ?? 'لا توجد ملاحظات' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4">المنتجات المستلمة</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>حالة الجودة</th>
                            <th>رقم الدفعة</th>
                            <th>تاريخ الصلاحية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($goodsReceivedNote->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->pivot->quantity }}</td>
                                <td>{{ __($item->pivot->quality_status) }}</td>
                                <td>{{ $item->pivot->lot_number ?? 'N/A' }}</td>
                                <td>
                                    {{ $item->pivot->expiry_date ? \Carbon\Carbon::parse($item->pivot->expiry_date)->format('Y-m-d') : 'N/A' }}
                                </td>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="action-buttons mt-4">
                    <a href="{{ route('goods-received-notes.index') }}"
                        class="btn btn-secondary animate__animated animate__pulse">عودة</a>
                    <a href="{{ route('goods-received-notes.edit', $goodsReceivedNote) }}"
                        class="btn btn-primary animate__animated animate__pulse">تعديل</a>
                </div>
            </div>
        </div>
    </div>
@endsection
