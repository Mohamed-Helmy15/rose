{{-- resources/views/dashboard/products/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'المنتجات - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root { --primary: #4361ee; --danger: #f72585; --success: #4cc9f0; --warning: #ffb400; }
    .product-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.07); transition: all 0.35s; height: 100%; display: flex; flex-direction: column; }
    .product-card:hover { transform: translateY(-6px) scale(1.015); box-shadow: 0 20px 40px rgba(67,97,238,0.18); }
    .product-image { width: 100%; height: 160px; object-fit: cover; border-bottom: 4px solid var(--primary); }
    .low-stock-badge { background: var(--danger) !important; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    .stats-card { background: linear-gradient(135deg, var(--primary), #5e7bff); color: white; border-radius: 16px; padding: 1.5rem; text-align: center; }
    .stats-card h3 { font-size: 2rem; font-weight: 700; margin: 0; }
    .action-btn { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .action-btn:hover { transform: scale(1.1); }
    .empty-state { text-align: center; padding: 4rem 1rem; color: #999; }
    .empty-state i { font-size: 5rem; color: #e0e0e0; margin-bottom: 1rem; }
</style>
@endsection

@section('content')
<div class="container-fluid">
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
            <h4 class="fw-bold">قائمة المنتجات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-primary">المنتجات</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary rounded-pill px-4">
            <i class='bx bxs-plus-circle'></i> إضافة منتج
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stats-card">
                <h3>{{ $products->count() }}</h3>
                <p>إجمالي المنتجات</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
                <h3>{{ $products->where('is_active', true)->count() }}</h3>
                <p>نشطة</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f72585, #ff6b9d);">
                <h3>{{ $lowStockCount }}</h3>
                <p>منخفض المخزون</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                <h3>{{ $products->sum(fn($p) => $p->getAvailableQuantityAttribute()) }}</h3>
                <p>إجمالي الكمية</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            @php
                $available = $product->getAvailableQuantityAttribute();
                $isLow = $available <= ($product->reorder_level ?? 10);
            @endphp
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="product-card">
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/'.$product->primaryImage->image_path) }}" class="product-image" alt="{{ $product->name }}">
                    @else
                        <div class="product-image d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, {{ $product->color }}20, {{ $product->color }}60);">
                            <i class='bx bxs-florist' style="font-size: 4rem; color: {{ $product->color }};"></i>
                        </div>
                    @endif

                    <div class="p-4 d-flex gap-3 flex-grow-1">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:56px;height:56px;background:{{ $product->color }};">
                                {{ strtoupper(substr($product->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1">{{ $product->name }}</h6>
                            <small class="text-muted"><i class='bx bx-barcode'></i> {{ $product->sku }}</small>
                            <p class="text-primary fw-bold mb-2">{{ number_format($product->priceWithTax(), 2) }} ج.م</p>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($product->categories->take(2) as $cat)
                                    <span class="badge bg-light text-dark small">{{ $cat->name }}</span>
                                @endforeach
                                <span class="badge {{ $isLow ? 'bg-danger low-stock-badge' : 'bg-success' }} small">
                                    {{ $available }} متوفر
                                </span>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }} small">
                                    {{ $product->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 p-3 d-flex gap-2">
                        <a href="{{ route('products.show', $product) }}" class="action-btn btn-outline-primary" title="عرض"><i class='bx bx-show'></i></a>
                        <a href="{{ route('products.edit', $product) }}" class="action-btn btn-outline-warning" title="تعديل"><i class='bx bx-edit'></i></a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn btn-outline-danger" title="حذف"
                                onclick="return confirm('هل أنت متأكد من حذف {{ addslashes($product->name) }}؟')">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class='bx bxs-package'></i>
                    <h5>لا توجد منتجات</h5>
                    <a href="{{ route('products.create') }}" class="btn btn-primary rounded-pill px-4">
                        <i class='bx bxs-plus-circle'></i> إضافة منتج
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection