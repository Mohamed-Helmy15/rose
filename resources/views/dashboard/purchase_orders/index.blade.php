{{-- resources/views/dashboard/purchase_orders/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'أوامر الشراء - زهور')

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

        .po-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .po-card:hover {
            transform: translateY(-6px) scale(1.015);
            box-shadow: 0 20px 40px rgba(67, 97, 238, 0.18);
            z-index: 5;
        }

        .po-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            flex-shrink: 0;
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

        .stats-card p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
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
            .po-card {
                font-size: 0.9rem;
            }

            .po-avatar {
                width: 48px;
                height: 48px;
                font-size: 1.1rem;
            }

            .action-btn {
                width: 34px;
                height: 34px;
                font-size: 0.9rem;
            }

            .stats-card h3 {
                font-size: 1.6rem;
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

        {{-- Toast --}}
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

        {{-- العنوان + زر الإضافة --}}
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 animate__animated animate__fadeInDown">
            <div>
                <h4 class="mb-1 fw-bold text-dark">قائمة أوامر الشراء</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                        <li class="breadcrumb-item active text-primary">أوامر الشراء</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('purchase-orders.create') }}"
                class="btn btn-primary rounded-pill shadow-sm d-flex align-items-center gap-2 px-4 py-2 animate__animated animate__pulse animate__infinite animate__slower">
                <i class='bx bxs-plus-circle'></i>
                <span class="d-none d-sm-inline">إضافة أمر شراء</span>
            </a>
        </div>

        {{-- الإحصائيات --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3 animate__animated animate__fadeInLeft">
                <div class="stats-card">
                    <h3>{{ $purchaseOrders->count() }}</h3>
                    <p>إجمالي أوامر الشراء</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
                <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
                    <h3>{{ $purchaseOrders->where('status', 'pending')->count() }}</h3>
                    <p>معلقة</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.1s">
                <div class="stats-card" style="background: linear-gradient(135deg, #f72585, #ff6b9d);">
                    <h3>{{ $purchaseOrders->where('status', 'received')->count() }}</h3>
                    <p>مستلمة</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
                <div class="stats-card" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                    <h3>{{ number_format($purchaseOrders->sum('total_amount'), 2) }}</h3>
                    <p>إجمالي المبلغ</p>
                </div>
            </div>
        </div>

        {{-- البحث والفلترة --}}
        <div class="card mb-4 p-3 p-md-4 animate__animated animate__fadeInUp">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-6 position-relative">
                    <i class="bx bx-search search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="ابحث برقم الأمر أو اسم المورد..."
                        x-model="searchQuery" @input.debounce.300ms="searchQuery = $event.target.value">
                </div>
                <div class="col-6 col-md-3">
                    <select class="form-select filter-select" x-model="statusFilter">
                        <option value="">كل الحالات</option>
                        <option value="pending">معلق</option>
                        <option value="received">مستلم</option>
                        <option value="partial">جزئي</option>
                        <option value="cancelled">ملغى</option>
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

        {{-- كروت أوامر الشراء --}}
        <div class="row g-3 g-md-4">
            @forelse($purchaseOrders as $po)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3"
                    x-show="
                    (!searchQuery || 
                     '{{ $po->id }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                     '{{ $po->supplier->name }}'.toLowerCase().includes(searchQuery.toLowerCase()))
&&
                    (!statusFilter || '{{ $po->status }}' == statusFilter)
                 "
                    x-transition:enter="animate__animated animate__fadeInUp" x-transition:enter-start="animate__faster"
                    style="display: none;">

                    <div class="po-card">
                        <div class="p-3 p-md-4 d-flex gap-3 flex-grow-1">
                            <div class="po-avatar">
                                PO
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-1 fw-bold text-dark text-truncate">#{{ $po->id }} -
                                    {{ $po->supplier->name }}</h6>
                                <p class="mb-1 text-muted small text-truncate">
                                    <i class='bx bx-calendar'></i> {{ $po->order_date->format('Y-m-d') }}
                                </p>
                                <p class="mb-2 text-primary small">
                                    {{ number_format($po->total_amount, 2) }} {{ settings('currency') }}
                                </p>
                                <div class="d-flex gap-2 flex-wrap">
                                    <span
                                        class="badge bg-light text-dark small">{{ $po->expected_delivery_date->format('Y-m-d') }}</span>
                                    <span
                                        class="badge {{ $po->status == 'pending' ? 'bg-warning' : ($po->status == 'received' ? 'bg-success' : 'bg-danger') }} rounded-pill small">
                                        {{ __($po->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light border-0 p-3 d-flex gap-2">
                            <a href="{{ route('purchase-orders.show', $po) }}" class="action-btn btn-outline-primary"
                                title="عرض">
                                <i class='bx bx-show'></i>
                            </a>
                            @if ($po->status == 'pending')
                                <a href="{{ route('purchase-orders.edit', $po) }}" class="action-btn btn-outline-warning"
                                    title="تعديل">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <form action="{{ route('purchase-orders.destroy', $po) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-outline-danger" title="حذف"
                                        onclick="return confirm('هل أنت متأكد من حذف أمر الشراء #{{ $po->id }}؟')">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state animate__animated animate__fadeIn">
                        <i class='bx bxs-cart'></i>
                        <h5 class="mb-2">لا توجد أوامر شراء</h5>
                        <p class="text-muted mb-3">ابدأ بإضافة أمر شراء جديد</p>
                        <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary rounded-pill px-4">
                            <i class='bx bxs-plus-circle'></i> إضافة أمر شراء
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
