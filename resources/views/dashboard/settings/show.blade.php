{{-- resources/views/dashboard/branches/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل الفرع - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .info-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: background 0.3s ease;
        }
        .info-card:hover {
            background: #e9ecef;
        }
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">الفروع /</span> {{ $branch->name }}
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">{{ $branch->name }} <small class="text-muted">({{ $branch->code }})</small></h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                        <div class="info-card">
                            <h6 class="section-title">المدير</h6>
                            <p>{{ $branch->manager?->name ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                        <div class="info-card">
                            <h6 class="section-title">عدد الموظفين</h6>
                            <p>{{ $branch->employees->count() }} موظف</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                        <div class="info-card">
                            <h6 class="section-title">الهاتف</h6>
                            <p>{{ $branch->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                        <div class="info-card">
                            <h6 class="section-title">الحالة</h6>
                            <p>{{ $branch->is_active ? 'نشط' : 'معطل' }}</p>
                        </div>
                    </div>
                    <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                        <div class="info-card">
                            <h6 class="section-title">العنوان</h6>
                            <p>{{ $branch->address ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('branches.index') }}" class="btn btn-secondary animate__animated animate__pulse">عودة</a>
                    <a href="{{ route('branches.edit', $branch) }}" class="btn btn-primary animate__animated animate__pulse">تعديل</a>
                </div>
            </div>
        </div>
    </div>
@endsection