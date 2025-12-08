{{-- resources/views/dashboard/inventory/pick-lists.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'قوائم الانتقاء - زهور')

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

        .pick-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .pick-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(67, 135, 238, 0.22);
            z-index: 10;
        }

        .pick-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-radius: 16px;
            padding: 1.8rem;
            text-align: center;
            height: 100%;
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.2);
        }

        .stats-card h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .stats-card p {
            font-size: 0.95rem;
            opacity: 0.95;
            margin: 8px 0 0;
        }

        .search-input {
            border-radius: 50px;
            padding: 0.7rem 1rem 0.7rem 3rem;
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
            left: 18px;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 1.2rem;
            pointer-events: none;
        }

        .filter-select {
            border-radius: 50px;
            padding: 0.65rem 1.2rem;
            font-size: 0.95rem;
            border: 1.5px solid var(--border);
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.25s ease;
        }

        .action-btn:hover {
            transform: scale(1.15);
        }

        .empty-state {
            text-align: center;
            padding: 5rem 1rem;
            color: #999;
        }

        .empty-state i {
            font-size: 6rem;
            color: #e0e0e0;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 576px) {
            .stats-card h3 {
                font-size: 1.8rem;
            }

            .pick-avatar {
                width: 48px;
                height: 48px;
                font-size: 1.1rem;
            }

            .action-btn {
                width: 36px;
                height: 36px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid" x-data="{ searchQuery: '', statusFilter: '' }">

        {{-- Toast --}}
        @if (session('toast'))
            <div class="bs-toast toast toast-placement-ex m-3 fade show bg-{{ session('toast.type') }} animate__animated animate__bounceInDown"
                role="alert" data-bs-delay="5000">
                <div class="toast-header bg-white border-bottom">
                    <i class='bx bx-bell me-2 text-primary'></i>
                    <div class="me-auto fw-semibold">إشعار</div>
                    <small class="text-muted">الآن</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">{{ session('toast.message') }}</div>
            </div>
        @endif

        {{-- العنوان --}}
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 animate__animated animate__fadeInDown">
            <div>
                <h4 class="mb-1 fw-bold text-dark">قوائم الانتقاء</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="text-muted">المخازن</a>
                        </li>
                        <li class="breadcrumb-item active text-primary">قوائم الانتقاء</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- الإحصائيات --}}
        {{-- <div class="row g-3 mb-5">
            <div class="col-6 col-md-3 animate__animated animate__fadeInLeft">
                <div class="stats-card">
                    <h3>{{ $pickLists->count() }}</h3>
                    <p>إجمالي القوائم</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
                <div class="stats-card" style="background: linear-gradient(135deg, #ff6b6b, #f72585);">
                    <h3>{{ $pickLists->where('status', 'pending')->count() }}</h3>
                    <p>قيد الانتظار</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.1s">
                <div class="stats-card" style="background: linear-gradient(135deg, #4361ee, #5e7bff);">
                    <h3>{{ $pickLists->where('status', 'preparing')->count() }}</h3>
                    <p>جاري التجهيز</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
                <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
                    <h3>{{ $pickLists->where('status', 'ready')->count() }}</h3>
                    <p>جاهزة للتسليم</p>
                </div>
            </div>
        </div> --}}

        {{-- البحث والفلترة --}}
        <div class="card mb-4 p-4 animate__animated animate__fadeInUp">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-6 position-relative">
                    <i class="bx bx-search search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="ابحث برقم الطلب أو اسم العميل..."
                        x-model.debounce.500ms="searchQuery">
                </div>
                <div class="col-12 col-md-4">
                    <select class="form-select filter-select" x-model="statusFilter">
                        <option value="">كل الحالات</option>
                        <option value="pending">قيد الانتظار</option>
                        <option value="preparing">جاري التجهيز</option>
                        <option value="ready">جاهز للتسليم</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 text-md-end">
                    <button class="btn btn-outline-secondary rounded-pill w-100"
                        @click="searchQuery = ''; statusFilter = ''">
                        <i class='bx bx-reset'></i> مسح
                    </button>
                </div>
            </div>
        </div>

        {{-- كروت قوائم الانتقاء --}}
        <div class="row g-4">
            @forelse($pickLists as $pickList)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3"
                    x-show="
                     (!searchQuery ||
                      '{{ $pickList->order->order_number }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                      '{{ $pickList->order->customer_name }}'.toLowerCase().includes(searchQuery.toLowerCase()))
&&
                     (!statusFilter || '{{ $pickList->status }}' === statusFilter)
                 "
                    x-transition:enter="animate__animated animate__fadeInUp" x-transition:enter-start="animate__faster">

                    <div class="pick-card">
                        <div class="p-4 d-flex gap-3 flex-grow-1">
                            <div class="pick-avatar">
                                PL
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-1 fw-bold text-dark text-truncate">
                                    طلب #{{ $pickList->order->order_number }}
                                </h6>
                                <p class="mb-1 text-muted small">
                                    <i class='bx bx-user'></i> {{ $pickList->order->customer_name }}
                                </p>
                                <p class="mb-2 small text-primary">
                                    <strong>{{ $pickList->items->count() }}</strong> صنف
                                    <br>
                                    <strong>{{ $pickList->items->sum('required_quantity') }}</strong> وحدة
                                </p>
                                <div class="d-flex gap-2 flex-wrap">
                                    <span
                                        class="badge rounded-pill
                                    {{ $pickList->status == 'pending'
                                        ? 'bg-warning text-dark'
                                        : ($pickList->status == 'prepared'
                                            ? 'bg-info'
                                            : 'bg-success') }}">
                                        {{ $pickList->status == 'pending'
                                            ? 'قيد الانتظار'
                                            : ($pickList->status == 'prepared'
                                                ? 'جاري التجهيز'
                                                : 'جاهز') }}
                                    </span>
                                    @if ($pickList->preparedBy)
                                        <span class="badge bg-light text-dark">
                                            <i class='bx bx-check-circle'></i> {{ $pickList->preparedBy->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light border-0 p-3 d-flex justify-content-between align-items-center">
                            <a href="{{ route('orders.show', $pickList->order) }}" class="action-btn btn-outline-primary"
                                title="عرض الطلب">
                                <i class='bx bx-show'></i>
                            </a>
                            @if ($pickList->status === 'pending')
                                <form action="{{ route('inventory.pickLists.prepare', $pickList) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="action-btn btn-outline-success" title="بدء التجهيز">
                                        <i class='bx bx-package'></i>
                                    </button>
                                </form>
                            @elseif($pickList->status === 'prepared')
                                <form action="{{ route('inventory.pickLists.complete', $pickList) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    <button type="submit" class="action-btn btn-success" title="إكمال التجهيز">
                                        <i class='bx bx-check-double'></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state animate__animated animate__fadeIn">
                        <i class='bx bxs-select-multiple'></i>
                        <h5 class="mb-3">لا توجد قوائم انتقاء حالياً</h5>
                        <p class="text-muted">عندما يتم إنشاء طلبات جديدة، ستظهر قوائم الانتقاء هنا</p>
                    </div>
                </div>
        </div>
        @endforelse
    </div>
    </div>
@endsection

@section('page-script')
    <script>
        // إخفاء التوست تلقائيًا بعد 5 ثواني
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelectorAll('.bs-toast').forEach(t => t.classList.remove('show'));
            }, 5000);
        });
    </script>
@endsection
