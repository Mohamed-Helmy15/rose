{{-- resources/views/dashboard/orders/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل الطلب #{{ $order->order_number }} - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .info-box { background: #f8f9fa; padding: 20px; border-radius: 12px; }
    .status-badge { font-size: 0.9rem; padding: 8px 16px; border-radius: 50px; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">الطلبات /</span> تفاصيل الطلب #{{ $order->order_number }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">طلب رقم {{ $order->order_number }}</h5>
            <span class="status-badge" style="background: {{ $order->getStatusBadgeAttribute }}; color: white;">
                {{ $order->getStatusArabicAttribute() }}
            </span>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6"><div class="info-box"><h6>العميل</h6><p class="mb-0">{{ $order->customer_name }}<br>{{ $order->customer_phone }}</p></div></div>
                <div class="col-md-6"><div class="info-box"><h6>العنوان</h6><p class="mb-0">{{ $order->customer_address ?: 'غير محدد' }}</p></div></div>
                <div class="col-md-6"><div class="info-box"><h6>الفرع</h6><p>{{ $order->branch?->name ?? 'غير محدد' }}</p></div></div>
                <div class="col-md-6"><div class="info-box"><h6>المصدر</h6><p>{{ $order->source == 'pos' ? 'من الفرع' : 'من الموقع' }}</p></div></div>
                <div class="col-md-6"><div class="info-box"><h6>تاريخ الطلب</h6><p>{{ $order->created_at->format('d/m/Y H:i') }}</p></div></div>
                <div class="col-md-6"><div class="info-box"><h6>طريقة الدفع</h6><p>{{ $order->payment_method == 'cash' ? 'كاش' : 'فيزا' }}</p></div></div>
            </div>

            <h5 class="mt-5 mb-3">المنتجات</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>سعر الوحدة</th>
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
                <div class="col-md-5">
                    <div class="info-box">
                        <div class="d-flex justify-content-between mb-2"><span>الإجمالي:</span> <strong>{{ number_format($order->subtotal, 2) }} ج.م</strong></div>
                        @if($order->tax > 0)<div class="d-flex justify-content-between mb-2"><span>الضريبة:</span> <strong>{{ number_format($order->tax, 2) }} ج.م</strong></div>@endif
                        @if($order->shipping > 0)<div class="d-flex justify-content-between mb-2"><span>الشحن:</span> <strong>{{ number_format($order->shipping, 2) }} ج.م</strong></div>@endif
                        @if($order->discount > 0)<div class="d-flex justify-content-between mb-2 text-danger"><span>الخصم:</span> <strong>-{{ number_format($order->discount, 2) }} ج.م</strong></div>@endif
                        <div class="d-flex justify-content-between fs-4 fw-bold text-primary border-top pt-3 mt-3">
                            <span>الإجمالي النهائي:</span>
                            <strong>{{ number_format($order->total, 2) }} ج.م</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-end">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary me-2">عودة</a>
                <a href="{{ route('orders.print.a4', $order) }}" target="_blank" class="btn btn-success me-2">فاتورة A4</a>
                <a href="{{ route('orders.print.thermal', $order) }}" target="_blank" class="btn btn-info">فاتورة حرارية</a>
            </div>
        </div>
    </div>
</div>
@endsection