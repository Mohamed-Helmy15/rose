@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل المخزن - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --danger: #f72585;
        --success: #4cc9f0;
    }

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
    .product-image-large {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
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
        <span class="text-muted fw-light">المخازن /</span> {{ $warehouse->name }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">{{ $warehouse->name }}</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 text-center mb-4">
                    <div class="product-image-large d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--primary)20, var(--primary)80);">
                        <i class='bx bxs-warehouse' style="font-size: 6rem; color: white;"></i>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <div class="section-content">
                                <h6 class="section-title">الكمية الإجمالية</h6>
                                <p class="fs-4 fw-bold text-primary">{{ $warehouse->inventory->sum('quantity') }} قطعة</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <div class="section-content">
                                <h6 class="section-title">منتجات منخفضة</h6>
                                <p class="{{ $warehouse->inventory->where('quantity', '<=', 'min_stock_level')->count() > 0 ? 'text-danger' : 'text-success' }} fs-4 fw-bold">
                                    {{ $warehouse->inventory->where('quantity', '<=', 'min_stock_level')->count() }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <div class="section-content">
                                <h6 class="section-title">نوع المخزن</h6>
                                <p>{{ $warehouse->is_refrigerated ? 'مبرد (فريش)' : 'جاف (هدايا)' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <div class="section-content">
                                <h6 class="section-title">الحالة</h6>
                                <p>{{ $warehouse->is_active ? 'نشط' : 'معطل' }}</p>
                            </div>
                        </div>
                        <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                            <div class="section-content">
                                <h6 class="section-title">العنوان</h6>
                                <p>{{ $warehouse->address ?? 'لا عنوان' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('inventory.movements') }}" class="btn btn-info me-2">عرض الحركات</a>
                <a href="{{ route('inventory.batches') }}" class="btn btn-warning me-2">عرض الدفعات</a>
                <a href="{{ route('inventory.pick-lists') }}" class="btn btn-secondary me-2">قوائم الانتقاء</a>
                <a href="{{ route('inventory.deliveries') }}" class="btn btn-success">التوصيلات</a>
            </div>

            <div class="action-buttons mt-4">
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary animate__animated animate__pulse">عودة</a>
                <a href="{{ route('inventory.edit', $warehouse) }}" class="btn btn-primary animate__animated animate__pulse">تعديل</a>
            </div>
        </div>
    </div>
</div>
@endsection