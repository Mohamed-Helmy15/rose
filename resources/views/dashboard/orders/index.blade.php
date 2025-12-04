@extends('layouts/contentNavbarLayout')

@section('title', 'الطلبات - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --primary-light: #5e7bff;
        --danger: #f72585;
        --success: #10b981;
        --warning: #f59e0b;
        --info: #0dcaf0;
        --border: #e9ecef;
    }

    .order-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .order-card:hover {
        transform: translateY(-6px) scale(1.015);
        box-shadow: 0 20px 40px rgba(67, 97, 238, 0.18);
        z-index: 5;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .search-input, .filter-select {
        border-radius: 50px;
        padding: 0.65rem 1rem 0.65rem 2.8rem;
        border: 1.5px solid var(--border);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-input:focus, .filter-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.22rem rgba(67, 97, 238, 0.18);
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

    .empty-state i {
        font-size: 5rem;
        color: #e0e0e0;
    }
</style>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelectorAll('.bs-toast').forEach(t => t.classList.remove('show'));
        }, 4000);
    });
</script>
@endsection

@section('content')
<div class="container-fluid" x-data="{ statusFilter: '', sourceFilter: '', searchQuery: '' }">

    @if(session('toast'))
        <div class="bs-toast toast toast-placement-ex m-3 fade show bg-{{ session('toast.type') }} text-white animate__animated animate__bounceInDown">
            <div class="toast-body">{{ session('toast.message') }}</div>
        </div>
    @endif

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 animate__animated animate__fadeInDown">
        <div>
            <h4 class="mb-1 fw-bold text-dark">قائمة الطلبات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-primary">الطلبات</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pos') }}" class="btn btn-success rounded-pill shadow-sm px-4 py-2">
                <i class='bx bx-cart-add'></i> نقطة بيع POS
            </a>
            <a href="{{ route('orders.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4 py-2">
                <i class='bx bxs-plus-circle'></i> طلب جديد
            </a>
        </div>
    </div>

    <!-- الإحصائيات -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3 animate__animated animate__fadeInLeft">
            <div class="stats-card">
                <h3>{{ $orders->total() }}</h3>
                <p>إجمالي الطلبات</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
            <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
                <h3>{{ $orders->where('status', 'delivered')->count() }}</h3>
                <p>تم التسليم</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.1s">
            <div class="stats-card" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
                <h3>{{ $orders->whereIn('status', ['ready', 'preparing'])->count() }}</h3>
                <p>قيد التجهيز</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
            <div class="stats-card" style="background: linear-gradient(135deg, #f72585, #ff6b9d);">
                <h3>{{ number_format($orders->sum('total'), 0) }}</h3>
                <p>إجمالي المبيعات</p>
            </div>
        </div>
    </div>

    <!-- البحث والفلترة -->
    <div class="card mb-4 p-3 p-md-4 animate__animated animate__fadeInUp">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-5 position-relative">
                <i class="bx bx-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="ابحث برقم الطلب أو اسم العميل..."
                       x-model="searchQuery" @input.debounce.300ms="searchQuery = $event.target.value">
            </div>
            <div class="col-6 col-md-3">
                <select class="form-select filter-select" x-model="statusFilter">
                    <option value="">كل الحالات</option>
                    <option value="new">جديد</option>
                    <option value="preparing">قيد التجهيز</option>
                    <option value="ready">جاهز</option>
                    <option value="out_for_delivery">في التوصيل</option>
                    <option value="delivered">تم التسليم</option>
                    <option value="canceled">ملغي</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select class="form-select filter-select" x-model="sourceFilter">
                    <option value="">كل المصادر</option>
                    <option value="pos">من الفرع</option>
                    <option value="website">من الموقع</option>
                    <option value="whatsapp">واتساب</option>
                    <option value="phone">تليفون</option>
                </select>
            </div>
            <div class="col-12 col-md-1 text-md-end">
                <button class="btn btn-outline-secondary rounded-pill w-100"
                        @click="searchQuery = ''; statusFilter = ''; sourceFilter = ''">
                    <i class='bx bx-reset'></i>
                </button>
            </div>
        </div>
    </div>

    <!-- كروت الطلبات -->
    <div class="row g-3 g-md-4">
        @forelse($orders as $order)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3"
                 x-show="
                    (!searchQuery || 
                     '{{ $order->order_number }}'.includes(searchQuery) ||
                     '{{ $order->customer_name }}'.toLowerCase().includes(searchQuery.toLowerCase())) &&
                    (!statusFilter || '{{ $order->status }}' === statusFilter) &&
                    (!sourceFilter || '{{ $order->source }}' === sourceFilter)
                 "
                 x-transition:enter="animate__animated animate__fadeInUp"
                 style="display: none;">
                <div class="order-card">
                    <div class="p-3 p-md-4 d-flex gap-3 flex-grow-1">
                        <div class="flex-shrink-0">
                            <div class="p-1 text-white fw-bold" style="background: {{ $order->status == 'delivered' ? '#10b981' : ($order->status == 'canceled' ? '#f72585' : '#4361ee') }}">
                                #{{ Str::after($order->order_number, '-') }}
                            </div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-1 fw-bold text-dark">{{ $order->customer_name }}</h6>
                            <p class="mb-1 text-muted small">
                                <i class='bx bx-phone'></i> {{ $order->customer_phone }}
                            </p>
                            <p class="mb-2 text-muted small">
                                <i class='bx bx-time'></i> {{ $order->created_at->diffForHumans() }}
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="status-badge" style="background: {{ $order->getStatusBadgeAttribute }}; color: white;">
                                    {{ $order->getStatusArabicAttribute() }}
                                </span>
                                <span class="badge bg-light text-dark small">
                                    {{ ucfirst($order->source) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 p-3 d-flex justify-content-between align-items-center">
                        <div class="fw-bold text-primary">
                            {{ number_format($order->total, 2) }} {{ settings('currency') }}
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="action-btn btn-outline-primary" title="عرض">
                                <i class='bx bx-show'></i>
                            </a>
                            <a href="{{ route('orders.print.a4', $order) }}" target="_blank" class="action-btn btn-outline-success" title="فاتورة A4">
                                <i class='bx bx-printer'></i>
                            </a>
                            <a href="{{ route('orders.print.thermal', $order) }}" target="_blank" class="action-btn btn-outline-info" title="فاتورة حرارية">
                                <i class='bx bxs-receipt'></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state text-center py-5 animate__animated animate__fadeIn">
                    <i class='bx bxs-cart'></i>
                    <h5 class="mb-2">لا توجد طلبات</h5>
                    <p class="text-muted mb-3">ابدأ بإضافة طلب جديد</p>
                    <a href="{{ route('pos') }}" class="btn btn-primary rounded-pill px-4">
                        <i class='bx bx-cart-add'></i> نقطة البيع
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection