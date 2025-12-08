{{-- resources/views/dashboard/inventory/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل المخزن - {{ $warehouse->name }}')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .info-box {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid #eee;
    }
    .warehouse-icon {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4361ee, #5e7bff);
        color: white;
        font-size: 4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    .badge-low { background: #dc2626; }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">المخازن /</span> {{ $warehouse->name }}
    </h4>

    <div class="card shadow-lg animate__animated animate__zoomIn">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $warehouse->name }}</h5>
            <span class="badge {{ $warehouse->is_active ? 'bg-light text-success' : 'bg-dark' }} fs-6">
                {{ $warehouse->is_active ? 'نشط' : 'معطل' }}
            </span>
        </div>

        <div class="card-body">
            <div class="py-4 row align-items-center">
                

                <div class="col-lg-9">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="text-muted">إجمالي الكمية في المخزن</h6>
                                <p class="fs-2 fw-bold text-primary">{{ number_format($warehouse->total_quantity) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="text-muted">منتجات منخفضة المخزون</h6>
                                <p class="fs-2 fw-bold {{ $warehouse->low_stock_count > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $warehouse->low_stock_count }}
                                    @if($warehouse->low_stock_count > 0)
                                        <i class='bx bx-bell bx-tada'></i>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="text-muted">الفرع</h6>
                                <p class="fw-bold">{{ $warehouse->branch?->name ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="text-muted">العنوان</h6>
                                <p>{{ $warehouse->address ?: 'غير محدد' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-5">

            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('inventory.movements') }}" class="btn btn-info">
                    <i class='bx bx-transfer'></i> حركات المخزون
                </a>
                <a href="{{ route('inventory.batches') }}" class="btn btn-warning">
                    <i class='bx bx-package'></i> الدفعات (Batches)
                </a>
                <a href="{{ route('inventory.pick-lists') }}" class="btn btn-success">
                    <i class='bx bx-list-check'></i> قوائم التحضير
                </a>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-2">رجوع</a>
                <a href="{{ route('inventory.edit', $warehouse) }}" class="btn btn-primary">تعديل المخزن</a>
            </div>
        </div>
    </div>
</div>
@endsection