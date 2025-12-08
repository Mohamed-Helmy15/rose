{{-- resources/views/dashboard/inventory/batches.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'الدفعات - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root { --primary: #4361ee; --danger: #f72585; --success: #4cc9f0; --warning: #ffb400; }
    .table th, .table td { vertical-align: middle; }
    .badge-expired { background: var(--danger) !important; animation: pulse 2s infinite; }
    .badge-near { background: var(--warning) !important; }
    @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    .search-input, .filter-select { border-radius: 50px; }
    .empty-state i { font-size: 5rem; color: #e0e0e0; }
</style>
@endsection

@section('content')
<div class="container-fluid" x-data="{ searchQuery: '', statusFilter: '', warehouseFilter: '' }">
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
            <h4 class="fw-bold">الدفعات (Batches)</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="text-muted">المخازن</a></li>
                    <li class="breadcrumb-item active text-primary">الدفعات</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card mb-4 p-4">
        <div class="row g-3">
            <div class="col-md-4 position-relative">
                <i class="bx bx-search position-absolute top-50 start-3 translate-middle-y text-muted"></i>
                <input type="text" class="form-control ps-5 search-input" placeholder="ابحث برقم الدفعة أو المنتج..." x-model.debounce.300ms="searchQuery">
            </div>
            <div class="col-md-3">
                <select class="form-select filter-select" x-model="statusFilter">
                    <option value="">كل الحالات</option>
                    <option value="available">متاح</option>
                    <option value="near_expiry">قريب الانتهاء</option>
                    <option value="expired">منتهي الصلاحية</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select filter-select" x-model="warehouseFilter">
                    <option value="">كل المخازن</option>
                    @foreach(\App\Models\Warehouse::active()->get() as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100 rounded-pill" @click="searchQuery=''; statusFilter=''; warehouseFilter=''">
                    <i class='bx bx-reset'></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>رقم الدفعة</th>
                        <th>المنتج</th>
                        <th>المخزن</th>
                        <th>الكمية</th>
                        <th>تاريخ الاستلام</th>
                        <th>تاريخ الصلاحية</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batches as $batch)
                        @php
                            $daysLeft = $batch->expiry_date?->diffInDays(now(), false);
                            $isExpired = $batch->isExpired();
                            $isNearExpiry = !$isExpired && $daysLeft !== null && $daysLeft <= 7;
                        @endphp
                        <tr x-show="
                            (!searchQuery || 
                             '{{ $batch->lot_number ?? '' }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                             '{{ $batch->product->name }}'.toLowerCase().includes(searchQuery.toLowerCase())) &&
                            (!statusFilter || 
                                (statusFilter == 'near_expiry' ? {{ $isNearExpiry ? 'true' : 'false' }} :
                                 statusFilter == 'expired' ? {{ $isExpired ? 'true' : 'false' }} :
                                 '{{ $batch->status }}' == 'available')) &&
                            (!warehouseFilter || '{{ $batch->warehouse_id }}' == warehouseFilter)
                        ">
                            <td><strong>{{ $batch->lot_number ?: 'غير محدد' }}</strong></td>
                            <td>{{ $batch->product->name }}</td>
                            <td>{{ $batch->warehouse->name }}</td>
                            <td><strong>{{ $batch->quantity }}</strong></td>
                            <td>{{ $batch->receive_date->format('d/m/Y') }}</td>
                            <td>{{ $batch->expiry_date?->format('d/m/Y') ?: 'غير محدد' }}</td>
                            <td>
                                @if($isExpired)
                                    <span class="badge bg-danger badge-expired">منتهي الصلاحية</span>
                                @elseif($isNearExpiry)
                                    <span class="badge bg-warning badge-near">قريب الانتهاء ({{ $daysLeft }} يوم)</span>
                                @else
                                    <span class="badge bg-success">متاح</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 empty-state">
                                <i class='bx bxs-box'></i>
                                <h5>لا توجد دفعات</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection