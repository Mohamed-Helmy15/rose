{{-- resources/views/dashboard/goods_received_notes/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إيصالات الاستلام - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --danger: #f72585;
            --success: #4cc9f0;
            --warning: #ffb400;
        }

        .grn-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            transition: all 0.35s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .grn-card:hover {
            transform: translateY(-6px) scale(1.015);
            box-shadow: 0 20px 40px rgba(67, 97, 238, 0.18);
        }

        .grn-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #5e7bff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--primary), #5e7bff);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
        }

        .stats-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
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
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        @if (session('toast'))
            <div class="bs-toast toast toast-placement-ex m-3 fade show bg-{{ session('toast.type') }} animate__animated animate__bounceInDown"
                role="alert" data-bs-delay="4000">
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
                <h4 class="fw-bold">إيصالات الاستلام (GRN)</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                        <li class="breadcrumb-item active text-primary">إيصالات الاستلام</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('goods-received-notes.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class='bx bxs-plus-circle'></i> إضافة إيصال استلام
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stats-card">
                    <h3>{{ $grns->count() }}</h3>
                    <p>إجمالي الإيصالات</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
                    <h3>{{ $grns->where('status', 'completed')->count() }}</h3>
                    <p>مكتملة</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #f72585, #ff6b9d);">
                    <h3>{{ $grns->sum(fn($g) => $g->items->where('pivot.quality_status', 'rejected')->sum('pivot.quantity')) }}
                    </h3>
                    <p>كمية مرفوضة</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                    <h3>{{ $grns->sum(fn($g) => $g->items->where('pivot.quality_status', 'accepted')->sum('pivot.quantity')) }}
                    </h3>
                    <p>كمية مقبولة</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($grns as $grn)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="grn-card">
                        <div class="p-4 d-flex gap-3 flex-grow-1">
                            <div class="grn-avatar">GRN</div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">#{{ $grn->id }}</h6>
                                <small class="text-muted d-block">#PO-{{ $grn->purchaseOrder->id }}</small>
                                <small class="text-muted d-block">{{ $grn->purchaseOrder->supplier->name }}</small>
                                <small class="text-muted"><i class='bx bx-calendar'></i>
                                    {{ $grn->received_date->format('d/m/Y') }}</small>
                                @php
                                    $original = $grn->purchaseOrder->products->sum('pivot.quantity');

                                    $accepted = $grn->items
                                        ->where('pivot.quality_status', 'accepted')
                                        ->sum('pivot.quantity');

                                    $partial_received = $grn->items
                                        ->where('pivot.quality_status', 'partial')
                                        ->sum('pivot.quantity');

                                    $allGrns = $grn->purchaseOrder->goodsReceivedNotes()->with('items')->get();

                                    $totalReceived = 0;

                                    foreach ($allGrns as $oneGrn) {
                                        $totalReceived += $oneGrn->items
                                            ->whereIn('pivot.quality_status', ['accepted', 'partial'])
                                            ->sum('pivot.quantity');
                                    }

                                    $rejected_real = max(0, $original - $totalReceived);
                                @endphp

                                <p class="mt-2 mb-0">

                                    <strong class="text-primary">{{ $original }}</strong> أصل الطلب
                                    <br>

                                    <strong class="text-success">{{ $accepted }} مقبولة</strong>
                                    <br>

                                    <strong class="text-warning">{{ $partial_received }}جزئي</strong>
                                    <br>

                                    <strong class="text-danger">{{ $rejected_real }}مرفوض</strong>

                                </p>

                            </div>
                        </div>
                        <div class="card-footer bg-light border-0 p-3 d-flex gap-2">
                            <a href="{{ route('goods-received-notes.show', $grn) }}" class="action-btn btn-outline-primary"
                                title="عرض"><i class='bx bx-show'></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class='bx bxs-receipt'></i>
                        <h5>لا توجد إيصالات استلام</h5>
                        <a href="{{ route('goods-received-notes.create') }}" class="btn btn-primary rounded-pill px-4">
                            <i class='bx bxs-plus-circle'></i> إضافة إيصال استلام
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
