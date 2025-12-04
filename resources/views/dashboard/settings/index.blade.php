{{-- resources/views/dashboard/settings/index.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'الإعدادات العامة - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    :root {
        --primary: #4361ee;
        --primary-light: #5e7bff;
        --danger: #f72585;
        --success: #4cc9f0;
        --warning: #ffb400;
    }
    .setting-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        overflow: hidden;
    }
    .setting-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px rgba(67,97,238,0.22);
    }
    .group-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        padding: 1.2rem 1.5rem;
        font-weight: 600;
        border-radius: 18px 18px 0 0;
    }
    .logo-preview {
        width: 120px;
        height: 120px;
        object-fit: contain;
        border-radius: 16px;
        border: 4px solid #fff;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(67,97,238,0.2);
    }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">

    @if(session('toast'))
        <div class="bs-toast toast toast-placement-ex m-3 fade show bg-{{ session('toast.type') }} text-white animate__animated animate__bounceInDown">
            <div class="toast-header bg-transparent border-0">
                <i class='bx bx-bell me-2'></i>
                <div class="me-auto fw-semibold">إشعار</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">{{ session('toast.message') }}</div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeInDown">
        <div>
            <h4 class="fw-bold mb-1">الإعدادات العامة للنظام</h4>
            <p class="text-muted">تحكم كامل في سلوك النظام والمتجر</p>
        </div>
        <button type="submit" form="settingsForm" class="btn btn-primary btn-lg rounded-pill shadow-lg px-5 animate__animated animate__pulse animate__infinite animate__slower">
            <i class='bx bx-save'></i> حفظ التغييرات
        </button>
    </div>

    <form id="settingsForm" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row g-4">
            @foreach($settings as $groupName => $groupSettings)
                <div class="col-12">
                    <div class="setting-card animate__animated animate__fadeInUp" style="animation-delay: 0.{{ $loop->index }}s">
                        <div class="group-header">
                            <i class='bx bxs-cog me-2'></i>
                            {{ __('settings.groups.' . $groupName) }}
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                @foreach($groupSettings as $setting)
                                    <div class="col-md-6 animate__animated animate__fadeIn" style="animation-delay: 0.{{ $loop->index + 1 }}s">
                                        <label class="form-label fw-semibold">
                                            {{ $setting->description }}
                                            @if(str($setting->key)->contains(['name', 'currency'])) <span class="text-danger">*</span> @endif
                                        </label>

                                        @if($setting->type === 'image')
                                            <div class="text-center">
                                                @if($setting->value)
                                                    <img src="{{ asset('storage/' . $setting->value) }}" class="logo-preview mb-3" alt="الشعار">
                                                @else
                                                    <div class="logo-preview bg-light d-flex align-items-center justify-content-center mb-3">
                                                        <i class='bx bxs-image' style="font-size: 3rem; color: #ccc;"></i>
                                                    </div>
                                                @endif
                                                <input type="file" name="settings[{{ $setting->key }}]" class="form-control" accept="image/*">
                                                <small class="text-muted">PNG, JPG, WEBP • حتى 2MB</small>
                                            </div>

                                        @elseif($setting->type === 'boolean')
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="settings[{{ $setting->key }}]" value="1"
                                                       {{ $setting->value ? 'checked' : '' }} style="width: 60px; height: 30px;">
                                                <label class="form-check-label">{{ $setting->value ? 'مفعل' : 'معطل' }}</label>
                                            </div>

                                        @elseif($setting->type === 'select' && $setting->key === 'language')
                                            <select name="settings[{{ $setting->key }}]" class="form-select">÷
                                                <option value="ar" {{ $setting->value == 'ar' ? 'selected' : '' }}>العربية</option>
                                                <option value="en" {{ $setting->value == 'en' ? 'selected' : '' }}>English</option>
                                            </select>

                                        @elseif($setting->key === 'inventory_method')
                                            <select name="settings[{{ $setting->key }}]" class="form-select">
                                                <option value="FIFO" {{ $setting->value == 'FIFO' ? 'selected' : '' }}>FIFO - الأقدم أولاً</option>
                                                <option value="FEFO" {{ $setting->value == 'FEFO' ? 'selected' : '' }}>FEFO - الأقرب انتهاءً أولاً</option>
                                            </select>

                                        @else
                                            <input type="{{ $setting->type === 'number' ? 'number' : 'text' }}"
                                                   name="settings[{{ $setting->key }}]"
                                                   class="form-control form-control-lg"
                                                   value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                                   placeholder="{{ $setting->description }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary btn-lg px-6 rounded-pill shadow-lg">
                <i class='bx bx-save bx-spin-hover'></i> حفظ جميع الإعدادات
            </button>
        </div>
    </form>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.querySelectorAll('.bs-toast').forEach(t => t.classList.remove('show'));
    }, 5000);
});
</script>
@endsection