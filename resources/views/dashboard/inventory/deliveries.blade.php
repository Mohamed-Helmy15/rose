{{-- resources/views/dashboard/inventory/deliveries.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'التوصيلات - زهور')

@section('content')
<div class="container-fluid" x-data="{ searchQuery: '', statusFilter: '' }">
    @if (session('toast'))
        <div class="bs-toast toast toast-placement-ex m-3 fade show bg-{{ session('toast.type') }} animate__animated animate__bounceInDown" role="alert" data-bs-delay="4000">
            <div class="toast-header bg-white border-bottom">
                <i class='bx bx-bell me-2 text-primary'></i>
                <div class="me-auto fw-semibold">إشعار</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">{{ session('toast.message') }}</div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">التوصيلات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="text-muted">المخازن</a></li>
                    <li class="breadcrumb-item active text-primary">التوصيلات</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card mb-4 p-4">
        <div class="row g-3">
            <div class="col-md-6 position-relative">
                <i class="bx bx-search position-absolute top-50 start-3 translate-middle-y text-muted"></i>
                <input type="text" class="form-control ps-5" placeholder="ابحث برقم الطلب..." x-model.debounce.300ms="searchQuery">
            </div>
            <div class="col-md-4">
                <select class="form-select" x-model="statusFilter">
                    <option value="">كل الحالات</option>
                    <option value="pending">قيد الانتظار</option>
                    <option value="out_for_delivery">في التوصيل</option>
                    <option value="delivered">تم التسليم</option>
                    <option value="failed">فشل التسليم</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($deliveries as $d)
            <div class="col-md-6 col-lg-4"
                 x-show="!searchQuery || '{{ $d->order->order_number }}'.includes(searchQuery)"
                 x-show="!statusFilter || '{{ $d->status }}' == statusFilter">
                <div class="card h-100 border-start {{ $d->status == 'delivered' ? 'border-success' : ($d->status == 'failed' ? 'border-danger' : 'border-warning') }} border-4">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between">
                            <strong>#{{ $d->order->order_number }}</strong>
                            <span class="badge bg-{{ $d->status == 'delivered' ? 'success' : ($d->status == 'failed' ? 'danger' : 'warning') }}">
                                {{ $d->status == 'pending' ? 'قيد الانتظار' : ($d->status == 'out_for_delivery' ? 'في التوصيل' : ($d->status == 'delivered' ? 'تم التسليم' : 'فشل')) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>العميل:</strong> {{ $d->order->customer_name }}</p>
                        <p><strong>المندوب:</strong> {{ $d->driver?->name ?? 'غير محدد' }}</p>
                        <p><strong>وقت التسليم:</strong> {{ $d->delivery_time?->format('d/m/Y H:i') ?: '—' }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('orders.show', $d->order) }}" class="btn btn-sm btn-primary">عرض الطلب</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class='bx bxs-truck fs-1 text-muted'></i>
                <h5 class="mt-3 text-muted">لا توجد توصيلات</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection