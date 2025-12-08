{{-- resources/views/dashboard/goods_received_notes/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل إيصال الاستلام - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
    .grn-avatar-large { width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #4361ee, #5e7bff); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: bold; }
    .info-box { background: #f8f9fa; padding: 20px; border-radius: 12px; }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">إيصالات الاستلام /</span> #{{ $goodsReceivedNote->id }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header bg-primary text-white">
            إيصال استلام #{{ $goodsReceivedNote->id }} - {{ $goodsReceivedNote->purchaseOrder->supplier->name }}
        </h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 text-center mb-4">
                    <div class="grn-avatar-large">GRN</div>
                </div>
                <div class="col-lg-9">
                    <div class="row g-4">
                        <div class="col-md-6"><div class="info-box"><h6>تاريخ الاستلام</h6><p>{{ $goodsReceivedNote->received_date->format('d/m/Y') }}</p></div></div>
                        <div class="col-md-6"><div class="info-box"><h6>المستلم</h6><p>{{ $goodsReceivedNote->receivedBy->name }}</p></div></div>
                        <div class="col-md-6"><div class="info-box"><h6>أمر الشراء</h6><p>#{{ $goodsReceivedNote->purchase_order_id }}</p></div></div>
                        <div class="col-md-6"><div class="info-box"><h6>الملاحظات</h6><p>{{ $goodsReceivedNote->notes ?: 'لا توجد' }}</p></div></div>
                    </div>
                </div>
            </div>

            <h5 class="mt-5 mb-3">المنتجات المستلمة</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
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
                                <td>
                                    <span class="badge bg-{{ $item->pivot->quality_status == 'accepted' ? 'success' : ($item->pivot->quality_status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ __($item->pivot->quality_status) }}
                                    </span>
                                </td>
                                <td>{{ $item->pivot->lot_number ?: 'غير محدد' }}</td>
                                <td>{{ $item->pivot->expiry_date ? \Carbon\Carbon::parse($item->pivot->expiry_date)->format('d/m/Y') : 'غير محدد' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('goods-received-notes.index') }}" class="btn btn-secondary">عودة إلى القائمة</a>
            </div>
        </div>
    </div>
</div>
@endsection