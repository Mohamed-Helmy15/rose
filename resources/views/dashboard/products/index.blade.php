{{-- resources/views/dashboard/products/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'المنتجات - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --primary-light: #5e7bff;
        --danger: #f72585;
        --success: #4cc9f0;
        --warning: #ffb400;
        --dark: #121212;
        --light: #fdfdfd;
        --gray: #6c757d;
        --border: #e9ecef;
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-6px) scale(1.015);
        box-shadow: 0 20px 40px rgba(67, 97, 238, 0.18);
        z-index: 5;
    }

    .product-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-bottom: 4px solid var(--primary);
    }

    .product-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .low-stock-badge {
        background: var(--danger) !important;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .search-input {
        border-radius: 50px;
        padding: 0.65rem 1rem 0.65rem 2.8rem;
        border: 1.5px solid var(--border);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.22rem rgba(67, 97, 238, 0.18);
        outline: none;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 14px;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 1.1rem;
        pointer-events: none;
    }

    .filter-select {
        border-radius: 50px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        border: 1.5px solid var(--border);
    }

    .filter-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
    }

    .stats-card {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        height: 100%;
    }

    .stats-card h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .stats-card p {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
    }

    .action-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        color: #999;
    }

    .empty-state i {
        font-size: 5rem;
        color: #e0e0e0;
        margin-bottom: 1rem;
    }

    @media (max-width: 576px) {
        .product-card { font-size: 0.9rem; }
        .product-avatar { width: 48px; height: 48px; font-size: 1.1rem; }
        .action-btn { width: 34px; height: 34px; font-size: 0.9rem; }
        .stats-card h3 { font-size: 1.6rem; }
    }
</style>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelectorAll('.bs-toast').forEach(t => t.classList.remove('show'));
        }, 4000);
    });
</script>
@endsection

@section('content')
<div class="container-fluid" x-data="{ searchQuery: '', categoryFilter: '', statusFilter: '' }">

    {{-- Toast --}}
    @if (session('toast'))
        <div class="bs-toast toast toast-placement-ex m-3 fade show {{ session('toast.type') }} animate__animated animate__bounceInDown"
            role="alert" data-bs-delay="4000">
            <div class="toast-header bg-white border-bottom">
                <i class='bx bx-bell me-2 text-primary'></i>
                <div class="me-auto fw-semibold">إشعار</div>
                <small class="text-muted">الآن</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">{{ session('toast.message') }}</div>
        </div>
    @endif

    {{-- العنوان + زر الإضافة --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 animate__animated animate__fadeInDown">
        <div>
            <h4 class="mb-1 fw-bold text-dark">قائمة المنتجات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-primary">المنتجات</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('products.create') }}"
           class="btn btn-primary rounded-pill shadow-sm d-flex align-items-center gap-2 px-4 py-2 animate__animated animate__pulse animate__infinite animate__slower">
            <i class='bx bxs-plus-circle'></i>
            <span class="d-none d-sm-inline">إضافة منتج</span>
        </a>
    </div>

    {{-- الإحصائيات --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3 animate__animated animate__fadeInLeft">
            <div class="stats-card">
                <h3>{{ $products->count() }}</h3>
                <p>إجمالي المنتجات</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
            <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
                <h3>{{ $products->where('is_active', true)->count() }}</h3>
                <p>نشطة</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.1s">
            <div class="stats-card" style="background: linear-gradient(135deg, #f72585, #ff6b9d);">
                <h3>{{ \App\Models\Product::select('reorder_level')->whereColumn('stock_quantity', '<=', 'reorder_level')->count() }}</h3>
                <p>منخفض المخزون</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
            <div class="stats-card" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                <h3>{{ $products->sum('stock_quantity') }}</h3>
                <p>إجمالي الكمية</p>
            </div>
        </div>
    </div>

    {{-- البحث والفلترة --}}
    <div class="card mb-4 p-3 p-md-4 animate__animated animate__fadeInUp">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-5 position-relative">
                <i class="bx bx-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="ابحث بالاسم، SKU، أو الوصف..."
                       x-model="searchQuery" @input.debounce.300ms="searchQuery = $event.target.value">
            </div>
            <div class="col-6 col-md-3">
                <select class="form-select filter-select" x-model="categoryFilter">
                    <option value="">كل التصنيفات</option>
                    @foreach(\App\Models\Category::active()->get() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select class="form-select filter-select" x-model="statusFilter">
                    <option value="">كل الحالات</option>
                    <option value="1">نشط</option>
                    <option value="0">معطل</option>
                    <option value="low">منخفض المخزون</option>
                </option>
                </select>
            </div>
            <div class="col-12 col-md-1 text-md-end">
                <button class="btn btn-outline-secondary rounded-pill w-100"
                        @click="searchQuery = ''; categoryFilter = ''; statusFilter = ''">
                    <i class='bx bx-reset'></i>
                </button>
            </div>
        </div>
    </div>

    {{-- كروت المنتجات --}}
    <div class="row g-3 g-md-4">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3"
                 x-show="
                    (!searchQuery || 
                     '{{ $product->name }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                     '{{ $product->sku }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                     ('{{ $product->description }}'.toLowerCase().includes(searchQuery.toLowerCase()))) &&
                    (!categoryFilter || @json($product->categories->pluck('id')->contains($categoryFilter ?? null))) &&
                    (!statusFilter || 
                        (statusFilter == 'low' ? {{ $product->isLowStock() ? 'true' : 'false' }} : '{{ $product->is_active }}' == statusFilter))
                 "
                 x-transition:enter="animate__animated animate__fadeInUp"
                 x-transition:enter-start="animate__faster"
                 style="display: none;">

                <div class="product-card">
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/'.$product->primaryImage->image_path) }}" class="product-image" alt="{{ $product->name }}">
                    @else
                        <div class="product-image d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, {{ $product->color }}20, {{ $product->color }}60);">
                            <i class='bx bxs-florist' style="font-size: 4rem; color: {{ $product->color }}; opacity: 0.8;"></i>
                        </div>
                    @endif

                    <div class="p-3 p-md-4 d-flex gap-3 flex-grow-1">
                        <div class="product-avatar" style="background: {{ $product->color }};">
                            {{ strtoupper(substr($product->name, 0, 2)) }}
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-1 fw-bold text-dark text-truncate">{{ $product->name }}</h6>
                            <p class="mb-1 text-muted small text-truncate">
                                <i class='bx bx-barcode'></i> {{ $product->sku }}
                            </p>
                            <p class="mb-2 text-primary small">
                                {{ number_format($product->priceWithTax(), 2) }} {{ settings('currency') }}
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($product->categories->take(2) as $cat)
                                    <span class="badge bg-light text-dark small">{{ $cat->name }}</span>
                                @endforeach
                                <span class="badge {{ $product->isLowStock() ? 'bg-danger low-stock-badge' : 'bg-success' }} rounded-pill small">
                                    {{ $product->stock_quantity }} قطعة
                                </span>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill small">
                                    {{ $product->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 p-3 d-flex gap-2">
                        <a href="{{ route('products.show', $product) }}" class="action-btn btn-outline-primary" title="عرض">
                            <i class='bx bx-show'></i>
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="action-btn btn-outline-warning" title="تعديل">
                            <i class='bx bx-edit'></i>
                        </a>
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
                <div class="empty-state animate__animated animate__fadeIn">
                    <i class='bx bxs-package'></i>
                    <h5 class="mb-2">لا توجد منتجات</h5>
                    <p class="text-muted mb-3">ابدأ بإضافة منتج جديد</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary rounded-pill px-4">
                        <i class='bx bxs-plus-circle'></i> إضافة منتج
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection