@extends('layouts/contentNavbarLayout')

@section('title', 'التوصيلات - زهور')

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

    .table th, .table td {
        vertical-align: middle;
    }

    .type-badge {
        font-size: 0.85rem;
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
        .table {
            font-size: 0.85rem;
        }
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
<div class="container-fluid" x-data="{ searchQuery: '', statusFilter: '' }">

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

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 animate__animated animate__fadeInDown">
        <div>
            <h4 class="mb-1 fw-bold text-dark">التوصيلات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="text-muted">المخازن</a></li>
                    <li class="breadcrumb-item active text-primary">التوصيلات</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card mb-4 p-3 p-md-4 animate__animated animate__fadeInUp">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-6 position-relative">
                <i class="bx bx-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="ابحث برقم الطلب..."
                       x-model="searchQuery" @input.debounce.300ms="searchQuery = $event.target.value">
            </div>
            <div class="col-6 col-md-3">
                <select class="form-select filter-select" x-model="statusFilter">
                    <option value="">كل الحالات</option>
                    <option value="pending">قيد الانتظار</option>
                    <option value="in_transit">في الطريق</option>
                    <option value="delivered">مُسلم</option>
                    <option value="failed">فشل</option>
                    <option value="returned">مُعاد</option>
                </select>
            </div>
            <div class="col-6 col-md-2 text-md-end">
                <button class="btn btn-outline-secondary rounded-pill w-100"
                        @click="searchQuery = ''; statusFilter = ''">
                    <i class='bx bx-reset'></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card animate__animated animate__fadeInUp">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>المندوب</th>
                        <th>وقت المجدول</th>
                        <th>وقت التسليم</th>
                        <th>الحالة</th>
                        <th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $delivery)
                        <tr x-show="
                            (!searchQuery || 
                             '{{ $delivery->order->id }}'.includes(searchQuery)) &&
                            (!statusFilter || '{{ $delivery->status }}' == statusFilter)
                         "
                         x-transition:enter="animate__animated animate__fadeInUp">
                            <td>{{ $delivery->order->id }}</td>
                            <td>{{ $delivery->driver->name ?? 'غير محدد' }}</td>
                            <td>{{ $delivery->scheduled_time ? $delivery->scheduled_time->format(settings('date_format', 'd/m/Y H:i')) : 'غير محدد' }}</td>
                            <td>{{ $delivery->delivery_time ? $delivery->delivery_time->format(settings('date_format', 'd/m/Y H:i')) : 'غير محدد' }}</td>
                            <td>
                                <span class="badge {{ $delivery->status == 'delivered' ? 'bg-success' : ($delivery->status == 'failed' ? 'bg-danger' : 'bg-warning') }} type-badge">
                                    {{ trans('inventory.delivery_statuses.' . $delivery->status) }}
                                </span>
                            </td>
                            <td>{{ $delivery->notes ?? 'غير محدد' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center empty-state">
                                <i class='bx bxs-truck'></i>
                                <h5 class="mb-2">لا توجد توصيلات</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection