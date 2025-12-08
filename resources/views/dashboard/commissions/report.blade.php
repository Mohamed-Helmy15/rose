{{-- resources/views/dashboard/commissions/report.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تقرير العمولات - ' . \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y'))

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root { --primary: #4361ee; --success: #10b981; --warning: #f59e0b; }
    .card { border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .stats-card { background: linear-gradient(135deg, var(--primary), #5e7bff); color: white; border-radius: 16px; padding: 1.5rem; text-align: center; }
    .stats-card h3 { font-size: 2.2rem; font-weight: 700; }
    table th { background: #f8f9fa; }
    .user-row:hover { background: #f1f3ff !important; }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">تقرير العمولات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-primary">تقرير العمولات</li>
                </ol>
            </nav>
        </div>

        <!-- اختيار الشهر -->
        <form method="GET" class="d-flex gap-2 align-items-center">
            <input type="month" name="month" class="form-control" value="{{ $month }}" required>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-search'></i> عرض
            </button>
        </form>
    </div>

    <!-- إجمالي العمولات -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stats-card">
                <h3>{{ number_format($totalCommission, 2) }} ج.م</h3>
                <p class="mb-0">إجمالي العمولات لشهر</p>
                <p class="fs-5">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}</p>
            </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <h5>عدد الموظفين الذين لهم عمولة: <strong>{{ $commissions->count() }}</strong></h5>
                    <h5>عدد الطلبات المحسوبة: <strong>{{ $commissions->sum(fn($g) => $g->count()) }}</strong></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول التفاصيل -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">تفاصيل العمولات حسب الموظف</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>الموظف</th>
                            <th>عدد الطلبات</th>
                            <th>إجمالي المبيعات</th>
                            <th>نسبة العمولة</th>
                            <th>إجمالي العمولة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commissions as $userId => $userCommissions)
                            @php
                                $user = $userCommissions->first()->user;
                                $totalSales = $userCommissions->sum(fn($c) => $c->order->total);
                                $totalCommission = $userCommissions->sum('commission_amount');
                                $avgRate = $userCommissions->avg('commission_rate');
                            @endphp
                            <tr class="user-row">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar rounded-circle bg-primary text-white fw-bold">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            <small class="d-block text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>{{ $userCommissions->count() }}</strong></td>
                                <td>{{ number_format($totalSales, 2) }} ج.م</td>
                                <td>
                                    <span class="badge bg-info">{{ number_format($avgRate, 1) }}%</span>
                                </td>
                                <td class="text-success fw-bold fs-5">
                                    {{ number_format($totalCommission, 2) }} ج.م
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class='bx bxs-wallet fs-1'></i>
                                    <p class="mt-3">لا توجد عمولات في هذا الشهر</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('commissions.report') }}?month={{ now()->subMonth()->format('Y-m') }}" class="btn btn-outline-secondary me-2">
            الشهر السابق
        </a>
        <a href="{{ route('commissions.report') }}?month={{ now()->addMonth()->format('Y-m') }}" class="btn btn-outline-secondary">
            الشهر التالي
        </a>
    </div>
</div>
@endsection