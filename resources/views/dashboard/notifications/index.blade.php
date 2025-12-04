{{-- resources/views/dashboard/notifications/index.blade.php --}}
@extends('layouts.contentNavbarLayout')

@section('title', 'الإشعارات • زهور بلس')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #4361ee;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #0ea5e9;
        --dark: #1e293b;
        --light: #f8fafc;
        --border: #e2e8f0;
    }

    @media (prefers-color-scheme: dark) {
        :root {
            --light: #0f172a;
            --dark: #f1f5f9;
            --border: #334155;
        }
        /* body { background: #0f172a; color: #e2e8f0; } */
        .notification-card { background: #1e293b; border: 1px solid #334155; }
    }

    body {
        font-family: 'Cairo', sans-serif;
        background: #f8fafc;
        min-height: 100vh;
    }

    .pulse-header {
        background: linear-gradient(135deg, var(--primary), #6366f1);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(67, 97, 238, 0.25);
        position: relative;
        overflow: hidden;
    }

    .pulse-header::before {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        animation: pulse-glow 8s infinite;
    }

    @keyframes pulse-glow {
        0%, 100% { transform: translate(20%, 20%) scale(1); opacity: 0.3; }
        50% { transform: translate(30%, 30%) scale(1.2); opacity: 0.6; }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.5rem;
        margin: 2rem 0;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(67,97,238,0.15);
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 900;
        background: linear-gradient(135deg, var(--primary), #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .filter-bar {
        background: white;
        border-radius: 16px;
        padding: 1rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        position: sticky;
        top: 20px;
        z-index: 100;
    }

    .timeline {
        position: relative;
        max-width: 1000px;
        margin: 3rem auto;
        padding: 2rem 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 50%;
        width: 4px;
        background: linear-gradient(to bottom, var(--primary), #a78bfa);
        border-radius: 2px;
        transform: translateX(-50%);
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.4);
        z-index: 1;
    }

    .notification-item {
        position: relative;
        margin: 3rem 0;
        opacity: 0;
        animation: floatIn 0.8s ease-out forwards;
    }

    @keyframes floatIn {
        to { opacity: 1; transform: translateY(0); }
    }

    .notification-item:nth-child(odd) .notification-card {
        margin-left: auto;
        margin-right: 50px;
    }

    .notification-item:nth-child(even) .notification-card {
        margin-right: auto;
        margin-left: 50px;
    }

    @media (max-width: 768px) {
        .notification-item .notification-card {
            margin-left: auto !important;
            margin-right: auto !important;
            width: 100% !important;
        }
    }

    .notification-card {
        width: 420px;
        max-width: 100%;
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        position: relative;
        transition: all 0.4s ease;
        border-left: 6px solid;
        border: 1px solid #e2e8f0;
        z-index: 2;
    }

    .notification-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 25px 50px rgba(67,97,238,0.25);
        z-index: 10;
    }

    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: white;
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        z-index: 3;
    }

    .type-create { border-left-color: var(--success); }
    .type-create .notification-icon { background: var(--success); }

    .type-update { border-left-color: var(--warning); }
    .type-update .notification-icon { background: var(--warning); }

    .type-delete { border-left-color: var(--danger); }
    .type-delete .notification-icon { background: var(--danger); }

    .type-info { border-left-color: var(--info); }
    .type-info .notification-icon { background: var(--info); }

    .today-badge {
        position: absolute;
        top: -12px;
        right: -12px;
        background: #ff006e;
        color: white;
        font-size: 0.7rem;
        padding: 4px 10px;
        border-radius: 50px;
        font-weight: 700;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .refresh-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), #6366f1);
        color: white;
        border: none;
        font-size: 1.3rem;
        animation: spin 2s linear infinite;
        cursor: pointer;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .empty-pulse {
        text-align: center;
        padding: 6rem 2rem;
        color: #94a3b8;
    }

    .empty-pulse i {
        font-size: 6rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
    }

    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 1rem;
        overflow-y: auto;
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        max-width: 600px;
        width: 100%;
        padding: 2rem;
        box-shadow: 0 30px 60px rgba(0,0,0,0.3);
        position: relative;
        animation: modalPop 0.4s ease-out;
    }

    @keyframes modalPop {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        font-size: 1.8rem;
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.2s;
    }

    .modal-close:hover { color: #ef4444; }

    body.modal-open { overflow: hidden; }
</style>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            document.querySelectorAll('.bs-toast').forEach(t => t.classList.remove('show'));
        }, 4000);
    });
</script>
@endsection

@section('content')
<div class="container-fluid" x-data="notificationsHub()" x-init="init()">

    {{-- Toast --}}
    @if (session('toast'))
        <div class="bs-toast toast toast-placement-ex m-3 fade show {{ session('toast.type') }} animate__animated animate__bounceInDown"
             style="z-index: 9999;" role="alert" data-bs-delay="4000">
            <div class="toast-header bg-white border-bottom">
                <i class='bx bx-bell me-2 text-primary'></i>
                <div class="me-auto fw-semibold">إشعار جديد</div>
                <small>الآن</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body fw-bold">
                {{ session('toast.message') }}
            </div>
        </div>
    @endif

    {{-- Header --}}
    <div class="pulse-header text-center mb-5 animate__animated animate__fadeInDown">
        <h1 class="display-4 fw-bold mb-3">زهور بلس</h1>
        <p class="lead opacity-90">مركز التحكم بالإشعارات – كل شيء تحت عينيك</p>
        <button @click="refresh()" class="refresh-btn shadow-lg">
            <i class='bx bx-refresh'></i>
        </button>
    </div>

    {{-- Stats --}}
    <div class="stats-grid container animate__animated animate__fadeInUp">
        <div class="stat-card">
            <div class="stat-number">{{ $notifications->total() }}</div>
            <p class="text-muted mb-0">إجمالي الإشعارات</p>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $todayCount }}</div>
            <p class="text-muted mb-0">اليوم</p>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $notifications->where('action', 'like', '%created%')->count() }}</div>
            <p class="text-muted mb-0">تم الإنشاء</p>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $notifications->where('action', 'like', '%deleted%')->count() }}</div>
            <p class="text-muted mb-0">تم الحذف</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="container filter-bar mb-5 animate__animated animate__fadeIn">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <select class="form-select rounded-pill" x-model="filterUser">
                    <option value="">كل المستخدمين</option>
                    @if($user->hasRole('admin'))
                        @foreach($notifications->pluck('actor')->unique('id') as $u)
                            <option value="{{ $u?->id }}">{{ $u?->name ?? 'غير معروف' }}</option>
                        @endforeach
                    @else
                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select rounded-pill" x-model="filterType">
                    <option value="">كل الأنواع</option>
                    <option value="create">إنشاء</option>
                    <option value="update">تعديل</option>
                    <option value="delete">حذف</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control rounded-pill" x-model="filterDate">
            </div>
            <div class="col-md-3 text-end">
                <button @click="resetFilters()" class="btn btn-outline-danger rounded-pill">
                    <i class='bx bx-reset'></i> مسح الفلاتر
                </button>
            </div>
        </div>
    </div>

    {{-- Timeline + Infinite Scroll --}}
    <div class="timeline" x-data="infiniteScroll()" x-init="init()">
        <div id="notifications-container">
            @include('dashboard.notifications.partials.timeline')
        </div>

        <div x-show="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">جاري التحميل...</span>
            </div>
        </div>

        <div x-show="noMoreData" class="text-center py-5 text-muted">
            <i class='bx bx-check-circle'></i>
            <p class="mt-2">تم تحميل كل الإشعارات</p>
        </div>
    </div>

    {{-- Modal --}}
    <div x-show="modalOpen" class="modal-backdrop" x-transition:enter="animate__animated animate__fadeIn faster"
         x-transition:leave="animate__animated animate__fadeOut faster" @click="modalOpen = false">
        <div @click.stop class="modal-content">
            <button @click="modalOpen = false" class="modal-close">×</button>
            <div class="text-center mb-6">
                <div class="notification-icon mx-auto text-5xl" :style="{ background: modalData.color }">
                    <i :class="modalData.icon"></i>
                </div>
                <h3 class="mt-4 text-2xl fw-bold" x-text="modalData.action"></h3>
            </div>
            <div class="space-y-4 text-lg">
                <p><strong>المنفذ:</strong> <span x-text="modalData.actor"></span></p>
                <p><strong>الوقت:</strong> <span x-text="modalData.time"></span></p>
                <p><strong>الوصف:</strong></p>
                <div class="bg-gray-100 p-4 rounded-12 text-sm" x-html="modalData.description"></div>
            </div>
            <div class="text-center mt-8">
                <button @click="modalOpen = false" class="btn btn-primary rounded-pill px-8">
                    تم، شكرًا!
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function notificationsHub() {
    return {
        filterUser: '',
        filterType: '',
        filterDate: '',
        modalOpen: false,
        modalData: {},

        init() {
            this.$watch('modalOpen', (val) => {
                document.body.classList.toggle('modal-open', val);
            });
        },

        showNotification(userId, type, date) {
            const matchesUser = !this.filterUser || userId == this.filterUser;
            const matchesType = !this.filterType || type.includes(this.filterType);
            const matchesDate = !this.filterDate || date === this.filterDate;
            return matchesUser && matchesType && matchesDate;
        },

        resetFilters() {
            this.filterUser = this.filterType = this.filterDate = '';
        },

        refresh() {
            location.reload();
        },

        showDetails(data) {
            const type = data.action.includes('created') ? 'create' :
                        data.action.includes('updated') ? 'update' :
                        data.action.includes('deleted') ? 'delete' : 'info';

            const colors = { create: '#10b981', update: '#f59e0b', delete: '#ef4444', info: '#0ea5e9' };

            this.modalData = {
                icon: type === 'create' ? 'bx bx-plus-circle' :
                      type === 'update' ? 'bx bx-edit' :
                      type === 'delete' ? 'bx bx-trash' : 'bx bx-bell',
                color: colors[type],
                action: data.action,
                actor: data.actor?.name || 'النظام',
                time: new Date(data.created_at).toLocaleString('ar-EG'),
                description: data.description
            };
            this.modalOpen = true;
        }
    }
}

function infiniteScroll() {
    return {
        loading: false,
        noMoreData: false,
        page: {{ $notifications->currentPage() }},

        init() {
            this.noMoreData = this.page >= {{ $notifications->lastPage() }};
            window.addEventListener('scroll', () => {
                if (this.noMoreData || this.loading) return;
                if (window.innerHeight + window.pageYOffset >= document.body.offsetHeight - 800) {
                    this.loadMore();
                }
            });
        },

        async loadMore() {
            if (this.loading || this.noMoreData) return;
            this.loading = true;
            this.page++;

            try {
                const url = new URL(window.location);
                url.searchParams.set('page', this.page);

                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const html = await response.text();
                document.getElementById('notifications-container').insertAdjacentHTML('beforeend', html);
                this.loading = false;

                if (this.page >= {{ $notifications->lastPage() }}) {
                    this.noMoreData = true;
                }
            } catch (error) {
                console.error('Error:', error);
                this.loading = false;
            }
        }
    }
}
</script>
@endsection