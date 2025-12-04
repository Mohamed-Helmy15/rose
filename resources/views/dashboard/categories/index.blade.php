{{-- resources/views/dashboard/categories/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'التصنيفات - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --primary-light: #5e7bff;
        --danger: #f72585;
        --success: #4cc9f0;
        --dark: #121212;
        --light: #fdfdfd;
        --gray: #6c757d;
        --border: #e9ecef;
    }

    .category-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        cursor: grab;
    }

    .category-card:hover {
        transform: translateY(-6px) scale(1.015);
        box-shadow: 0 20px 40px rgba(67, 97, 238, 0.18);
        z-index: 5;
    }

    .category-card.dragging {
        opacity: 0.5;
        transform: rotate(5deg);
    }

    .category-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .color-badge {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
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
    }

    .search-icon {
        position: absolute;
        top: 50%;
        left: 14px;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 1.1rem;
    }

    .filter-select {
        border-radius: 50px;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        border: 1.5px solid var(--border);
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
</style>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toast Auto Hide
        setTimeout(() => {
            document.querySelectorAll('.bs-toast').forEach(t => t.classList.remove('show'));
        }, 5000);

        // Drag & Drop Reorder
        const container = document.getElementById('categories-container');
        Sortable.create(container, {
            animation: 350,
            ghostClass: 'bg-light',
            onEnd: function () {
                const items = container.querySelectorAll('.category-item');
                const order = Array.from(items).map((el, index) => ({
                    id: el.dataset.id,
                    order: index + 1
                }));

                fetch('{{ route("categories.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order })
                });
            }
        });
    });
</script>
@endsection

@section('content')
<div class="container-fluid" x-data="{ statusFilter: '', searchQuery: '' }">

    {{-- Toast --}}
    @if (session('toast'))
        <div class="bs-toast toast toast-placement-ex m-3 fade show bg-{{ session('toast.type') }} text-white animate__animated animate__bounceInDown"
             role="alert" data-bs-delay="5000">
            <div class="toast-header bg-transparent border-0">
                <i class='bx bx-bell me-2'></i>
                <div class="me-auto fw-semibold">إشعار</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">{{ session('toast.message') }}</div>
        </div>
    @endif

    {{-- العنوان + زر الإضافة --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3 animate__animated animate__fadeInDown">
        <div>
            <h4 class="mb-1 fw-bold text-dark">قائمة التصنيفات</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item active text-primary">التصنيفات</li>
                </ol>
            </nav>
            <small class="text-muted">اسحب الكروت لتغيير ترتيب العرض</small>
        </div>
        <a href="{{ route('categories.create') }}"
           class="btn btn-primary rounded-pill shadow-sm d-flex align-items-center gap-2 px-4 py-2 animate__animated animate__pulse animate__infinite animate__slower">
            <i class='bx bxs-plus-circle'></i>
            <span class="d-none d-sm-inline">إضافة تصنيف</span>
        </a>
    </div>

    {{-- الإحصائيات --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3 animate__animated animate__fadeInLeft">
            <div class="stats-card">
                <h3>{{ $categories->count() }}</h3>
                <p>إجمالي التصنيفات</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
            <div class="stats-card" style="background: linear-gradient(135deg, #10b981, #34d399);">
                <h3>{{ $categories->where('is_active', true)->count() }}</h3>
                <p>نشطة</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.1s">
            <div class="stats-card" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">
                <h3>{{ $categories->whereNull('parent_id')->count() }}</h3>
                <p>تصنيفات رئيسية</p>
            </div>
        </div>
        <div class="col-6 col-md-3 animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
            <div class="stats-card" style="background: linear-gradient(135deg, #f72585, #ff6b9d);">
                <h3>{{ $categories->whereNotNull('parent_id')->count() }}</h3>
                <p>تصنيفات فرعية</p>
            </div>
        </div>
    </div>

    {{-- البحث والفلترة --}}
    <div class="card mb-4 p-3 p-md-4 animate__animated animate__fadeInUp">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-5 position-relative">
                <i class="bx bx-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="ابحث بالاسم، الكود..."
                       x-model="searchQuery" @input.debounce.300ms="searchQuery = $event.target.value">
            </div>
            <div class="col-6 col-md-3">
                <select class="form-select filter-select" x-model="statusFilter">
                    <option value="">كل الحالات</option>
                    <option value="1">نشط</option>
                    <option value="0">معطل</option>
                </select>
            </div>
            <div class="col-6 col-md-1 text-md-end">
                <button class="btn btn-outline-secondary rounded-pill w-100"
                        @click="statusFilter = ''; searchQuery = ''">
                    <i class='bx bx-reset'></i>
                </button>
            </div>
        </div>
    </div>

    {{-- كروت التصنيفات --}}
    <div class="row g-3 g-md-4" id="categories-container">
        @forelse($categories->sortBy('sort_order') as $category)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 category-item"
                 data-id="{{ $category->id }}"
                 x-show="
                    (!searchQuery ||
                     '{{ $category->name }}'.toLowerCase().includes(searchQuery.toLowerCase()) ||
                     '{{ $category->code }}'.toLowerCase().includes(searchQuery.toLowerCase())) &&
                    (statusFilter === '' || '{{ $category->is_active ? 1 : 0 }}' == statusFilter)
                 "
                 x-transition:enter="animate__animated animate__fadeInUp"
                 x-transition:enter-start="animate__faster"
                 style="display: none;">
                 
                <div class="category-card">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="category-image" alt="{{ $category->name }}">
                    @else
                        <div class="category-image d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, {{ $category->color }}20, {{ $category->color }}50);">
                            <i class='bx bxs-category' style="font-size: 4rem; color: {{ $category->color }}; opacity: 0.6;"></i>
                        </div>
                    @endif

                    <div class="p-3 p-md-4 d-flex gap-3 flex-grow-1">
                        <div class="color-badge flex-shrink-0" style="background-color: {{ $category->color }}"></div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="mb-1 fw-bold text-dark text-truncate">{{ $category->name }}</h6>
                            <p class="mb-1 text-muted small text-truncate">
                                <i class='bx bx-barcode'></i> {{ $category->code }}
                            </p>
                            @if($category->parent)
                                <p class="mb-2 text-primary small text-truncate">
                                    <i class='bx bx-folder'></i> {{ $category->parent->name }}
                                </p>
                            @endif
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill small">
                                    {{ $category->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light border-0 p-3 d-flex gap-2">
                        <a href="{{ route('categories.edit', $category) }}" class="action-btn btn-outline-warning" title="تعديل">
                            <i class='bx bx-edit'></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn btn-outline-danger" title="حذف"
                                    onclick="return confirm('هل أنت متأكد من حذف {{ addslashes($category->name) }}؟')">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state animate__animated animate__fadeIn">
                    <i class='bx bxs-category'></i>
                    <h5 class="mb-2">لا يوجد تصنيفات</h5>
                    <p class="text-muted mb-3">ابدأ بإضافة تصنيف جديد</p>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-pill px-4">
                        <i class='bx bxs-plus-circle'></i> إضافة تصنيف
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection