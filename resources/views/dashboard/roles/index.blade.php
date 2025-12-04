{{-- resources/views/roles/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'الأدوار - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --danger: #f72585;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --dark: #1f2937;
            --light: #f8fafc;
            --border: #e2e8f0;
        }

        .role-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .role-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(67, 97, 238, 0.18);
            z-index: 10;
        }

        .role-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #5e7bff);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .perm-badge {
            font-size: 0.65rem;
            padding: 3px 8px;
            border-radius: 50px;
            margin: 2px;
            display: inline-flex;
            white-space: nowrap;
        }

        .search-input {
            border-radius: 50px;
            padding: 0.65rem 1rem 0.65rem 2.8rem;
            border: 1.5px solid var(--border);
            font-size: 0.95rem;
        }

        .search-input:focus {
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
            background: linear-gradient(135deg, var(--primary), #5e7bff);
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
        }

        .stats-card p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 4.5rem;
            color: #e2e8f0;
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            font-weight: 600;
            color: #475569;
        }

        @media (max-width: 576px) {
            .role-icon {
                width: 42px;
                height: 42px;
                font-size: 1rem;
            }

            .action-btn {
                width: 32px;
                height: 32px;
                font-size: 0.85rem;
            }

            .stats-card h3 {
                font-size: 1.6rem;
            }
        }
    </style>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
    <div class="container-fluid" x-data="{ searchQuery: '', permFilter: '' }">

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
                <div class="toast-body">
                    {{ session('toast.message') }}
                </div>
            </div>
        @endif

        {{-- العنوان + زر الإضافة --}}
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 animate__animated animate__fadeInDown">
            <div>
                <h4 class="mb-1 fw-bold text-dark">قائمة الأدوار</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                        <li class="breadcrumb-item active text-primary">الأدوار</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('roles.create') }}"
                class="btn btn-primary rounded-pill shadow-sm d-flex align-items-center gap-2 px-4 py-2 animate__animated animate__pulse animate__infinite animate__slower">
                <i class='bx bxs-plus-circle'></i>
                <span class="d-none d-sm-inline">إضافة دور</span>
                <span class="d-sm-none">إضافة</span>
            </a>
        </div>

        {{-- الإحصائيات --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3 animate__animated animate__fadeInLeft">
                <div class="stats-card">
                    <h3>{{ $roles->count() }}</h3>
                    <p>الأدوار</p>
                </div>
            </div>
            <div class="col-6 col-md-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
                <div class="stats-card" style="background: linear-gradient(135deg, #f72585, #ff6b9d);">
                    <h3>{{ $allPermissions->count() }}</h3>
                    <p>الصلاحيات</p>
                </div>
            </div>
        </div>

        {{-- البحث + فلترة الصلاحيات --}}
        <div class="card mb-4 p-3 p-md-4 animate__animated animate__fadeInUp">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-5 position-relative">
                    <i class="bx bx-search search-icon"></i>
                    <input type="text" class="form-control search-input" placeholder="ابحث باسم الدور..."
                        x-model="searchQuery">
                </div>
                <div class="col-12 col-md-5">
                    <select class="form-select rounded-pill" x-model="permFilter">
                        <option value="">كل الصلاحيات</option>
                        @foreach ($allPermissions as $perm)
                            <option value="{{ $perm->name }}">{{ $perm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button class="btn btn-outline-secondary rounded-pill w-100" @click="searchQuery = ''; permFilter = ''">
                        <i class='bx bx-reset'></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- كروت الأدوار --}}
        <div class="row g-3 g-md-4">
            @forelse($roles as $role)
                <div class="col-12 col-sm-6 col-lg-4"
                    x-show="
         (!searchQuery || '{{ strtolower($role->name) }}'.includes(searchQuery.toLowerCase()))
&&
         (!permFilter || {{ Js::from($role->permissions->pluck('name')) }}.includes(permFilter))
     "
                    x-transition:enter="animate__animated animate__fadeInUp" style="display: none;">
                    <div class="role-card">
                        <div class="p-3 p-md-4 d-flex gap-3 flex-grow-1">
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-2 fw-bold text-dark text-truncate">{{ $role->name }}</h6>
                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    @foreach ($role->permissions as $perm)
                                        <span class="perm-badge bg-info text-white">
                                            {{ $perm->name }}
                                        </span>
                                    @endforeach
                                </div>
                                <small class="text-muted">
                                    {{ $role->permissions->count() }} صلاحية
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0 p-3 d-flex gap-2">
                            <a href="{{ route('roles.edit', $role) }}" class="action-btn btn-outline-warning"
                                title="تعديل">
                                <i class='bx bx-edit'></i>
                            </a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn btn-outline-danger" title="حذف"
                                    onclick="return confirm('هل أنت متأكد من حذف دور {{ addslashes($role->name) }}؟')">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state animate__animated animate__fadeIn">
                        <i class='bx bx-shield-x'></i>
                        <h5 class="mb-2">لا توجد أدوار</h5>
                        <p class="text-muted mb-3">ابدأ بإضافة دور جديد</p>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary rounded-pill px-4">
                            <i class='bx bxs-plus-circle'></i> إضافة دور
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
