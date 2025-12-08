{{-- resources/views/dashboard/inventory/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'المخازن - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --primary-light: #5e7bff;
        --danger: #dc2626;
        --success: #16a34a;
        --warning: #f59e0b;
        --border: #e5e7eb;
    }

    .warehouse-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .warehouse-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 30px 60px rgba(67, 97, 238, 0.22);
    }

    .warehouse-avatar {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        font-weight: 800;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-input {
        border-radius: 50px;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 1.5px solid var(--border);
        font-size: 0.95rem;
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.2);
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 18px;
        transform: translateY(-50%);
        color: #999;
        font-size: 1.2rem;
    }

    .filter-select {
        border-radius: 50px;
        padding: 0.65rem 1.2rem;
        border: 1.5px solid var(--border);
        font-size: 0.92rem;
    }

    .stats-card {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border-radius: 16px;
        padding: 1.8rem;
        text-align: center;
    }

    .stats-card h3 { font-size: 2.4rem; font-weight: 800; margin: 0; }
    .action-btn { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; }

    .low-stock-alert {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border-left: 6px solid var(--danger);
        animation: pulse 2.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.85; }
    }

    .empty-state i { font-size: 5rem; color: #e0e0e0; margin-bottom: 1rem; }
</style>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelectorAll('.bs-toast').forEach(t => t.classList.remove('show'));
        }, 5000);
    });
</script>
@endsection

@section('content')
<div class="container-fluid" x-data="{ searchQuery: '', statusFilter: '', refrigeratedFilter: '' }"
     x-init="$watch(['searchQuery','statusFilter','refrigeratedFilter'], () => {})">

    @if (session('toast'))
        <div class="bs-toast toast toast-placement-ex m-3 fade show bg-{{ session('toast.type') }} animate__animated animate__slideInDown"
             role="alert" data-bs-delay="5000">
            <div class="toast-header bg-white border-bottom">
                <i class='bx bx-bell me-2'></i>
                <div class="me-auto fw-bold">إشعار</div>
                <small>الآن</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body fw-semibold">{{ session('toast.message') }}</div>
        </div>
    @endif

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-4 animate__animated animate__fadeInDown">
        <div>
            <h4 class="mb-1 fw-bold text-dark">إدارة المخازن</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-primary">المخازن</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('inventory.create') }}"
           class="btn btn-primary rounded-pill shadow-lg d-flex align-items-center gap-2 px-5 py-3 animate__animated animate__pulse animate__infinite animate__slow">
            <i class='bx bxs-plus-circle fs-4'></i>
            <span class="d-none d-sm-inline">إضافة مخزن جديد</span>
            <span class="d-sm-none">إضافة</span>
        </a>
    </div>

    {{-- الإحصائيات --}}
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3 animate__animated animate__fadeInLeft">
            <div class="stats-card">
                <h3>{{ $warehouses->count() }}</h3>
                <p>إجمالي المخازن</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
            <div class="stats-card" style="background: linear-gradient(135deg, #16a34a, #22c55e);">
                <h3>{{ $warehouses->where('is_active', true)->count() }}</h3>
                <p>نشطة</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.1s">
            <div class="stats-card" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                <h3>{{ $totalLowStock }}</h3>
                <p>منتجات منخفضة</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
            <div class="stats-card" style="background: linear-gradient(135deg, #7c3aed, #a78bfa);">
                <h3>{{ number_format($totalQuantity) }}</h3>
                <p>إجمالي الكمية</p>
            </div>
        </div>
    </div>

    {{-- البحث والفلترة --}}
    <div class="card mb-4 p-4 shadow-sm animate__animated animate__fadeInUp">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-5 position-relative">
                <i class="bx bx-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="ابحث بالاسم، الفرع أو العنوان..."
                       x-model="searchQuery" @input.debounce.500ms="searchQuery = $event.target.value">
            </div>
            <div class="col-6 col-md-2">
                <select class="form-select filter-select" x-model="statusFilter">
                    <option value="">الحالة</option>
                    <option value="1">نشط</option>
                    <option value="0">معطل</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select class="form-select filter-select" x-model="refrigeratedFilter">
                    <option value="">نوع المخزن</option>
                    <option value="1">مبرد</option>
                    <option value="0">جاف</option>
                </select>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-outline-secondary rounded-pill w-100" @click="searchQuery=''; statusFilter=''; refrigeratedFilter=''">
                    <i class='bx bx-reset'></i> مسح
                </button>
            </div>
        </div>
    </div>

    {{-- كروت المخازن --}}
    <div class="row g-4">
        @forelse($warehouses as $warehouse)
            @php
                $totalQty = $totalQuantity;
                $lowCount = $warehouse->low_stock_count;
            @endphp
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3"
                 x-show="
                    (!searchQuery ||
                     '{{ $warehouse->name }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                     '{{ $warehouse->branch?->name ?? '' }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                     '{{ $warehouse->address ?? '' }}'.toLowerCase().includes(searchQuery.toLowerCase()))
                    &&
                    (statusFilter === '' || {{ $warehouse->is_active ? 1 : 0 }} == statusFilter)
                    &&
                    (refrigeratedFilter === '' || {{ $warehouse->is_refrigerated ? 1 : 0 }} == refrigeratedFilter)
                 "
                 x-transition:enter="animate__animated animate__fadeInUp"
                 style="display: none;">

                <div class="warehouse-card {{ $lowCount > 0 ? 'low-stock-alert' : '' }}">
                    <div class="p-4 d-flex gap-4 flex-grow-1">
                        <div class="warehouse-avatar">
                            {{ strtoupper(substr($warehouse->name, 0, 2)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $warehouse->name }}</h6>
                            <p class="small text-muted mb-2">
                                <i class='bx bx-building'></i> {{ $warehouse->branch?->name ?? 'بدون فرع' }}
                            </p>
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <span class="badge {{ $warehouse->is_refrigerated ? 'bg-info' : 'bg-secondary' }} text-white small px-3 py-2">
                                    {{ $warehouse->is_refrigerated ? 'مبرد' : 'جاف' }}
                                </span>
                                <span class="badge {{ $warehouse->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                                    {{ $warehouse->is_active ? 'نشط' : 'معطل' }}
                                </span>
                                @if($lowCount > 0)
                                    <span class="badge bg-danger rounded-pill">
                                        <i class='bx bx-bell'></i> منخفض ({{ $lowCount }})
                                    </span>
                                @endif
                            </div>
                            <p class="mb-0 fw-bold text-primary fs-4">{{ number_format($totalQty) }} قطعة</p>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 p-3 d-flex justify-content-center gap-3">
                        <a href="{{ route('inventory.show', $warehouse) }}" class="action-btn btn-outline-primary" title="عرض">
                            <i class='bx bx-show'></i>
                        </a>
                        <a href="{{ route('inventory.edit', $warehouse) }}" class="action-btn btn-outline-warning" title="تعديل">
                            <i class='bx bx-edit'></i>
                        </a>
                        <form action="{{ route('inventory.destroy', $warehouse) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn btn-outline-danger" title="حذف"
                                onclick="return confirm('متأكد من حذف مخزن «{{ addslashes($warehouse->name) }}»؟')">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5 animate__animated animate__zoomIn">
                    <i class='bx bxs-warehouse'></i>
                    <h5 class="mt-3 text-muted">لا توجد مخازن حالياً</h5>
                    <p class="text-muted mb-4">ابدأ بإضافة مخزن جديد</p>
                    <a href="{{ route('inventory.create') }}" class="btn btn-primary rounded-pill px-5 py-3">
                        <i class='bx bxs-plus-circle'></i> إضافة مخزن
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection