{{-- resources/views/dashboard/inventory/movements.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'حركات المخزون - زهور')

@section('content')
<div class="container-fluid" x-data="{ searchQuery: '', typeFilter: '' }">
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
            <h4 class="fw-bold">حركات المخزون</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="text-muted">المخازن</a></li>
                    <li class="breadcrumb-item active text-primary">الحركات</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card mb-4 p-4">
        <div class="row g-3">
            <div class="col-md-6 position-relative">
                <i class="bx bx-search position-absolute top-50 start-3 translate-middle-y text-muted"></i>
                <input type="text" class="form-control ps-5" placeholder="ابحث بالسبب أو المنتج..." x-model.debounce.300ms="searchQuery">
            </div>
            <div class="col-md-4">
                <select class="form-select" x-model="typeFilter">
                    <option value="">كل الأنواع</option>
                    <option value="in">دخول (استلام)</option>
                    <option value="out">خروج (بيع)</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>التاريخ</th>
                        <th>المنتج</th>
                        <th>الدفعة</th>
                        <th>المخزن</th>
                        <th>النوع</th>
                        <th>الكمية</th>
                        <th>السبب</th>
                        <th>المستخدم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $m)
                        <tr x-show="
                            (!searchQuery || 
                             '{{ $m->product->name }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                             '{{ $m->reason }}'.toLowerCase().includes(searchQuery.toLowerCase())) &&
                            (!typeFilter || '{{ $m->type }}' == typeFilter)
                        ">
                            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $m->product->name }}</td>
                            <td>{{ $m->batch?->lot_number ?: '—' }}</td>
                            <td>{{ $m->warehouse->name }}</td>
                            <td>
                                <span class="badge {{ $m->type == 'in' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $m->type == 'in' ? 'دخول' : 'خروج' }}
                                </span>
                            </td>
                            <td><strong>{{ $m->quantity }}</strong></td>
                            <td>{{ $m->reason ?: '—' }}</td>
                            <td>{{ $m->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class='bx bxs-transfer fs-1 text-muted'></i>
                                <h5 class="mt-3 text-muted">لا توجد حركات</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection