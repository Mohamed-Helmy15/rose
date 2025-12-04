{{-- resources/views/roles/create.blade.php & edit.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', ($role ? 'تعديل' : 'إضافة') . ' دور - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --primary-light: #5e7bff;
        --danger: #f72585;
        --success: #10b981;
        --warning: #f59e0b;
        --info: #0ea5e9;
        --dark: #1e293b;
        --light: #f8fafc;
        --border: #e2e8f0;
        --glass: rgba(255, 255, 255, 0.25);
        --shadow: 0 8px 32px rgba(67, 97, 238, 0.15);
    }

    .glass-card {
        background: var(--glass);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 20px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .perm-group {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1.5px solid var(--border);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .perm-group::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, transparent, rgba(67, 97, 238, 0.03));
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }

    .perm-group:hover::before {
        opacity: 1;
    }

    .perm-group:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(67, 97, 238, 0.15);
        border-color: var(--primary);
    }

    .perm-group-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    .perm-group-header i {
        font-size: 1.1rem;
    }

    .form-check {
        position: relative;
        padding-left: 2.2rem;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-check-input {
        width: 1.4em;
        height: 1.4em;
        margin-left: -2.2rem;
        border-radius: 8px;
        border: 2px solid #cbd5e1;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.2);
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.25);
        border-color: var(--primary);
    }

    .form-check-label {
        font-size: 0.95rem;
        color: #475569;
        cursor: pointer;
        transition: color 0.3s ease;
        font-weight: 500;
    }

    .form-check:hover .form-check-label {
        color: var(--primary);
    }

    .select-all {
        font-size: 0.8rem;
        color: var(--primary);
        font-weight: 600;
        cursor: pointer;
        text-decoration: underline;
        transition: all 0.2s ease;
    }

    .select-all:hover {
        color: var(--primary-light);
    }

    .counter {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
    }

    .role-name-input {
        font-size: 1.1rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        border: 2px solid var(--border);
        transition: all 0.3s ease;
    }

    .role-name-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.2);
    }

    .action-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        min-width: 120px;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .perm-group {
            padding: 1rem;
        }
        .perm-group-header {
            font-size: 0.8rem;
            padding: 0.6rem 1rem;
        }
    }
</style>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
<div class="container-fluid" x-data="roleForm()" x-init="init()">

    {{-- العنوان --}}
    <div class="d-flex align-items-center mb-4 animate__animated animate__fadeInDown">
        <h4 class="mb-0 fw-bold text-dark">
            <span class="text-muted fw-light">الأدوار /</span>
            <span class="text-primary">{{ $role ? 'تعديل' : 'إضافة' }}</span>
        </h4>
    </div>

    {{-- البطاقة الزجاجية --}}
    <div class="glass-card animate__animated animate__zoomIn">
        <div class="card-body p-4 p-md-5">

            <form action="{{ $role ? route('roles.update', $role) : route('roles.store') }}" method="POST">
                @csrf
                @if($role) @method('PUT') @endif

                {{-- اسم الدور --}}
                <div class="mb-5">
                    <label class="form-label fw-bold text-dark mb-3 d-block">
                        <i class='bx bx-shield-alt me-2 text-primary'></i>
                        اسم الدور
                    </label>
                    <input type="text" name="name" class="form-control role-name-input" 
                           value="{{ $role->name ?? old('name') }}" 
                           placeholder="مثال: مدير النظام، محرر المحتوى..."
                           x-model="roleName"
                           required>
                    @error('name')
                        <div class="text-danger mt-2 animate__animated animate__shakeX">
                            <i class='bx bx-error-circle'></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- الصلاحيات --}}
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 text-primary fw-bold">
                            <i class='bx bx-lock-open-alt me-2'></i>
                            الصلاحيات
                        </h5>
                        <div class="counter">
                            مختار: <span x-text="selectedCount"></span> من <span x-text="totalPermissions"></span>
                        </div>
                    </div>

                    <div class="row g-4">
                        @foreach($permissions as $group => $perms)
                            <div class="col-md-6 col-lg-4"
                                 x-data="{ group: '{{ $group }}' }"
                                 x-init="initGroup()"
                                 :class="{ 'animate__animated animate__fadeInUp': true }"
                                 style="animation-delay: {{ $loop->index * 0.1 }}s">
                                <div class="perm-group">
                                    <div class="perm-group-header">
                                        <i :class="getGroupIcon('{{ $group }}')"></i>
                                        {{ ucfirst(str_replace('_', ' ', $group)) }}
                                    </div>

                                    @foreach($perms as $perm)
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="permissions[]" 
                                                   value="{{ $perm->name }}"
                                                   class="form-check-input"
                                                   id="perm_{{ $perm->id }}"
                                                   x-model="selectedPermissions"
                                                   :value="'{{ $perm->name }}'"
                                                   {{ ($role && in_array($perm->name, $rolePermissions)) || (old('permissions') && in_array($perm->name, old('permissions'))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $perm->id }}">
                                                {{ $perm->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- الأزرار --}}
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-end mt-5">
                    <a href="{{ route('roles.index') }}" 
                       class="btn btn-outline-secondary action-btn d-flex align-items-center justify-content-center gap-2">
                        <i class='bx bx-arrow-back'></i>
                        إلغاء
                    </a>
                    <button type="submit" 
                            class="btn btn-primary action-btn d-flex align-items-center justify-content-center gap-2"
                            :disabled="!roleName.trim()">
                        <i class='bx bx-check-circle'></i>
                        <span x-show="{{ $role ? 'true' : 'false' }}">تحديث الدور</span>
                        <span x-show="{{ $role ? 'false' : 'true' }}">إضافة الدور</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function roleForm() {
    return {
        roleName: '{{ $role->name ?? old('name', '') }}',
        selectedPermissions: @js(($role ? $role->permissions->pluck('name')->toArray() : (old('permissions') ?? []))),
        totalPermissions: {{ count($permissions->flatten()) }},

        init() {
            this.$watch('selectedPermissions', () => this.updateCounters());
            this.updateCounters();
        },

        selectedCount: 0,
        groupCounts: {},

        updateCounters() {
            this.selectedCount = this.selectedPermissions.length;
            // تحديث العدادات لكل مجموعة
            document.querySelectorAll('[x-data]').forEach(el => {
                const group = el.getAttribute('x-data').match(/group: '([^']+)'/)?.[1];
                if (group) {
                    const count = this.selectedPermissions.filter(p => 
                        p.startsWith(group.replace(/_/g, '-') + '.')
                    ).length;
                    el.querySelector('[x-text="groupCount"]')?.setAttribute('x-text', count);
                }
            });
        },

        initGroup() {
            const group = this.group;
            const checkboxes = this.$el.querySelectorAll('input[type="checkbox"]');
            this.groupCount = 0;
            this.allInGroupSelected = false;

            this.$watch('selectedPermissions', () => {
                const groupPerms = Array.from(checkboxes).map(cb => cb.value);
                const selectedInGroup = this.selectedPermissions.filter(p => groupPerms.includes(p)).length;
                this.groupCount = selectedInGroup;
                this.allInGroupSelected = selectedInGroup === groupPerms.length;
            });
        },


        getGroupIcon(group) {
            const icons = {
                'users': 'bx bx-user',
                'roles': 'bx bx-shield',
                'permissions': 'bx bx-lock',
                'posts': 'bx bx-news',
                'settings': 'bx bx-cog',
                'dashboard': 'bx bx-home',
                'reports': 'bx bx-chart',
                'files': 'bx bx-folder',
                'default': 'bx bx-check-circle'
            };
            return icons[group] || icons['default'];
        }
    }
}
</script>
@endsection