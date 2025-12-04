@extends('layouts/contentNavbarLayout')

@section('title', 'تقرير العمولات - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --success: #10b981;
        --danger: #f72585;
        --warning: #f59e0b;
        --info: #0dcaf0;
    }
    .commission-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
    }
    .commission-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(67,97,238,0.22);
    }
    .avatar-xl {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    .total-card {
        background: linear-gradient(135deg, var(--primary), #5e7bff);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
    }
    .total-card h2 {
        font-size: 3rem;
        font-weight: 800;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">

    <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeInDown">
        <div>
            <h3 class="fw-bold mb-1">تقرير العمولات الشهرية</h3>
            <p class="text-muted">{{ now()->translatedFormat('F Y') }}</p>
        </div>
        <form method="GET" class="d-flex gap-2">
            <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}" class="form-control" onchange="this.form.submit()">
            <a href="{{ route('commissions.report') }}" class="btn btn-outline-secondary">اليوم</a>
        </form>
    </div>

    <!-- إجمالي العمولات -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="total-card animate__animated animate__zoomIn">
                <h2>{{ number_format($totalCommission, 2) }} {{ settings('currency') }}</h2>
                <p class="mb-0 fs-5 opacity-90">إجمالي العمولات هذا الشهر</p>
            </div>
        </div>
    </div>

    <!-- كروت الموظفين -->
    <div class="row g-4">
        @forelse($commissions as $userId => $userCommissions)
            @php
                $user = $userCommissions->first()->user;
                $totalSales = $userCommissions->sum(fn($c) => $c->order->total);
                $totalCommission = $userCommissions->sum('commission_amount');
                $ordersCount = $userCommissions->count();
            @endphp
            <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->iteration * 0.1 }}s">
                <div class="commission-card h-100">
                    <div class="p-4 text-center">
                        <div class="avatar avatar-xl rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold"
                             style="background: {{ $user->color ?? '#4361ee' }};">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ $user->roles->pluck('name')->first() ?? 'موظف' }}</p>

                        <div class="row text-center g-3">
                            <div class="col-4">
                                <h5 class="text-primary fw-bold">{{ $ordersCount }}</h5>
                                <small>طلب</small>
                            </div>
                            <div class="col-4">
                                <h5 class="text-success fw-bold">{{ number_format($totalSales) }}</h5>
                                <small>مبيعات</small>
                            </div>
                            <div class="col-4">
                                <h5 class="text-warning fw-bold">{{ number_format($totalCommission) }}</h5>
                                <small>عمولة</small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="text-start">
                            <small class="text-muted d-block mb-2">آخر 5 طلبات:</small>
                            @foreach($userCommissions->take(5) as $comm)
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>#{{ $comm->order->order_number }}</span>
                                    <span class="text-success">{{ number_format($comm->commission_amount, 2) }} ج.م</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class='bx bx-money' style="font-size: 5rem; color: #e0e0e0;"></i>
                <h4 class="mt-3">لا توجد عمولات هذا الشهر</h4>
            </div>
        @endforelse
    </div>
</div>
@endsection