@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل الطلب - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .section-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        transition: background 0.3s ease;
    }
    .section-content:hover {
        background: #e9ecef;
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
        <span class="text-muted fw-light">الطلبات /</span> تفاصيل الطلب #{{ $order->order_number }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">طلب رقم {{ $order->order_number }}</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                    <div class="section-content">
                        <h6 class="section-title">العميل</h6>
                        <p>{{ $order->customer_name }}<br>{{ $order->customer_phone }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                    <div class="section-content">
                        <h6 class="section-title">الفرع</h6>
                        <p>{{ $order->branch?->name ?? 'غير محدد' }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                    <div class="section-content">
                        <h6 class="section-title">المصدر</h6>
                        <p>{{ $order->source == 'pos' ? 'من الفرع' : ($order->source == 'website' ? 'من الموقع' : 'واتساب/تليفون') }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                    <div class="section-content">
                        <h6 class="section-title">الحالة</h6>
                        <span class="badge {{ $order->getStatusBadgeAttribute }}">{{ $order->getStatusArabicAttribute() }}</span>
                    </div>
                </div>
            </div>

            <h5 class="mt-4">المنتجات</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price_at_sale, 2) }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end mt-4">
                <div class="col-md-6">
                    <div class="section-content">
                        <div class="d-flex justify-content-between"><strong>الإجمالي قبل الضريبة:</strong> {{ number_format($order->subtotal, 2) }} {{ settings('currency') }}</div>
                        @if($order->tax > 0)
                        <div class="d-flex justify-content-between"><strong>الضريبة:</strong> {{ number_format($order->tax, 2) }} {{ settings('currency') }}</div>
                        @endif
                        @if($order->shipping > 0)
                        <div class="d-flex justify-content-between"><strong>الشحن:</strong> {{ number_format($order->shipping, 2) }} {{ settings('currency') }}</div>
                        @endif
                        @if($order->discount > 0)
                        <div class="d-flex justify-content-between"><strong>الخصم:</strong> -{{ number_format($order->discount, 2) }} {{ settings('currency') }}</div>
                        @endif
                        <div class="d-flex justify-content-between fs-4 fw-bold text-primary">
                            <strong>الإجمالي النهائي:</strong> {{ number_format($order->total, 2) }} {{ settings('currency') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons mt-4">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary animate__animated animate__pulse">عودة</a>
                <a href="{{ route('orders.print.a4', $order) }}" target="_blank" class="btn btn-success animate__animated animate__pulse">فاتورة A4</a>
                <a href="{{ route('orders.print.thermal', $order) }}" target="_blank" class="btn btn-info animate__animated animate__pulse">فاتورة حرارية</a>
            </div>
        </div>
    </div>
</div>
@endsection