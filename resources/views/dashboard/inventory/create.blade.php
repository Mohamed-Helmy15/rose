{{-- resources/views/dashboard/inventory/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة مخزن جديد - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .form-control, .form-select { border-radius: 10px; }
    .form-control:focus, .form-select:focus { border-color: #4361ee; box-shadow: 0 0 0 0.2rem rgba(67,97,238,0.25); }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">المخازن /</span> إضافة مخزن جديد
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header bg-primary text-white py-4">إضافة مخزن جديد</h5>
        <div class="card-body p-5">
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">اسم المخزن <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">العنوان</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                    </div>

                    @if(settings('multi_branch'))
                    <div class="col-md-6">
                        <label class="form-label">الفرع <span class="text-danger">*</span></label>
                        <select name="branch_id" class="form-select" required>
                            <option value="">-- اختر الفرع --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_refrigerated" value="1">
                            <label class="form-check-label">مخزن مبرد (للزهور الفريش)</label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-3 justify-content-end">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class='bx bx-check-circle'></i> حفظ المخزن
                    </button>
                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary btn-lg px-5">
                        <i class='bx bx-arrow-back'></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection