{{-- resources/views/dashboard/orders/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'الطلبات - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee; --success: #10b981; --danger: #f72585; --warning: #f59e0b; --info: #0dcaf0;
    }
    .order-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.07); transition: all 0.35s; height: 100%; display: flex; flex-direction: column; }
    .order-card:hover { transform: translateY(-6px) scale(1.015); box-shadow: 0 20px 40px rgba(67,97,238,0.18); }
    .status-badge { font-size: 0.75rem; padding: 6px 14px; border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .stats-card { background: linear-gradient(135deg, var(--primary), #5e7bff); color: white; border-radius: 16px; padding: 1.5rem; text-align: center; }
    .stats-card h3 { font-size: 2rem; font-weight: 700; margin: 0; }
    .action-btn { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
    .action-btn:hover { transform: scale(1.1); }
    .empty-state i { font-size: 5rem; color: #e0e0e0; }
</style>
@endsection

@section('content')
<div class="container-fluid" x-data="{ statusFilter: '', sourceFilter: '', searchQuery: '' }">
    @if(session('toast'))
        <div class="bs-toast toast toast-placement-ex m-3 fade show bg-{{ session('toast.type') }} text-white animate__animated animate__bounceInDown">
            <div class="toast-body">{{ session('toast.message') }}</div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">الطلبات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-primary">الطلبات</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pos') }}" class="btn btn-success rounded-pill shadow-sm px-4">
                <i class='bx bx-cart-add'></i> نقطة بيع
            </a>
        </div>
    </div>

    <!-- الإحصائيات -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3"><div class="stats-card"><h3>{{ $orders->total() }}</h3><p>إجمالي الطلبات</p></div></div>
        <div class="col-6 col-md-3"><div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);"><h3>{{ $orders->where('status', 'delivered')->count() }}</h3><p>تم التسليم</p></div></div>
        <div class="col-6 col-md-3"><div class="stats-card" style="background: linear-gradient(135deg, #f59e0b, #f97316);"><h3>{{ $orders->whereIn('status', ['preparing','ready','out_for_delivery'])->count() }}</h3><p>قيد التجهيز</p></div></div>
        <div class="col-6 col-md-3"><div class="stats-card" style="background: linear-gradient(135deg, #f72585, #ff6b9d);"><h3>{{ number_format($orders->sum('total'), 0) }}</h3><p>إجمالي المبيعات</p></div></div>
    </div>

    <!-- البحث والفلترة -->
    <div class="card mb-4 p-4">
        <div class="row g-3">
            <div class="col-md-5 position-relative">
                <i class="bx bx-search position-absolute top-50 start-3 translate-middle-y text-muted"></i>
                <input type="text" class="form-control ps-5 rounded-pill" placeholder="ابحث برقم الطلب أو العميل..." x-model.debounce.300ms="searchQuery">
            </div>
            <div class="col-md-3">
                <select class="form-select rounded-pill" x-model="statusFilter">
                    <option value="">كل الحالات</option>
                    <option value="new">جديد</option>
                    <option value="preparing">قيد التجهيز</option>
                    <option value="ready">جاهز</option>
                    <option value="out_for_delivery">في التوصيل</option>
                    <option value="delivered">تم التسليم</option>
                    <option value="canceled">ملغي</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select rounded-pill" x-model="sourceFilter">
                    <option value="">كل المصادر</option>
                    <option value="pos">من الفرع</option>
                    <option value="website">من الموقع</option>
                </select>
            </div>
        </div>
    </div>

    <!-- كروت الطلبات -->
    <div class="row g-4">
        @forelse($orders as $order)
            @php
                $statusColor = match($order->status) {
                    'delivered' => '#10b981',
                    'canceled' => '#f72585',
                    'out_for_delivery' => '#0dcaf0',
                    'ready' => '#f59e0b',
                    default => '#4361ee'
                };
            @endphp
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3"
                 x-show="
                    (!searchQuery || 
                     '{{ $order->order_number }}'.includes(searchQuery) ||
                     '{{ $order->customer_name }}'.toLowerCase().includes(searchQuery.toLowerCase())) &&
                    (!statusFilter || '{{ $order->status }}' === statusFilter) &&
                    (!sourceFilter || '{{ $order->source }}' === sourceFilter)
                 ">
                <div class="order-card">
                    <div class="p-4 d-flex gap-3 flex-grow-1">
                        <div class="flex-shrink-0">
                            <div class="text-white fw-bold rounded-pill px-3 py-2" style="background: {{ $statusColor }};">
                                #{{ Str::after($order->order_number, '-') }}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">{{ $order->customer_name }}</h6>
                            <small class="text-muted d-block mb-2">
                                <i class='bx bx-phone'></i> {{ $order->customer_phone }}
                            </small>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="status-badge" style="background: {{ $statusColor }}; color: white;">
                                    {{ $order->getStatusArabicAttribute() }}
                                </span>
                                <span class="badge bg-light text-dark small">
                                    {{ $order->source == 'pos' ? 'من الفرع' : 'من الموقع' }}
                                </span>
                            </div>
                            <p class="mt-2 mb-0 text-muted small">
                                <i class='bx bx-time'></i> {{ $order->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-0 p-3 d-flex justify-content-between align-items-center">
                        <strong class="text-primary fs-5">{{ number_format($order->total, 0) }} ج.م</strong>
                        <div class="d-flex gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="action-btn btn-outline-primary" title="عرض"><i class='bx bx-show'></i></a>
                            <a href="{{ route('orders.print.a4', $order) }}" target="_blank" class="action-btn btn-outline-success" title="A4"><i class='bx bx-printer'></i></a>
                            <a href="{{ route('orders.print.thermal', $order) }}" target="_blank" class="action-btn btn-outline-info" title="Thermal"><i class='bx bxs-receipt'></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class='bx bxs-cart fs-1 text-muted'></i>
                <h5 class="mt-3 text-muted">لا توجد طلبات</h5>
                <a href="{{ route('pos') }}" class="btn btn-success rounded-pill px-4 mt-3">
                    <i class='bx bx-cart-add'></i> ابدأ طلب جديد
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection