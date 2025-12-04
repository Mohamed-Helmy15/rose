{{-- create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إنشاء فرع - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
    <style>
        .form-control, .form-select {
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        .text-danger { font-size: 0.875rem; }

        .choices__list--dropdown, .choices__list[aria-expanded] {
            position: relative !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">الفروع /</span> إنشاء فرع
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">إنشاء فرع جديد</h5>
            <div class="card-body">
                <form action="{{ route('branches.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">اسم الفرع</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">كود الفرع</label>
                            <input type="text" class="form-control" name="code" value="{{ old('code') }}" required>
                            @error('code') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">مدير الفرع</label>
                            <select class="form-select" name="manager_id">
                                <option value="">-- اختر مدير --</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">الهاتف</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="col-12 animate__animated animate__fadeInUp">
                            <label class="form-label">الموظفين</label>
                            <select name="employee_ids[]" multiple class="form-select" id="employee-choices">
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 animate__animated animate__fadeInUp">
                            <label class="form-label">العنوان</label>
                            <textarea class="form-control" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">خط العرض</label>
                            <input type="number" step="any" class="form-control" name="latitude" value="{{ old('latitude') }}">
                        </div>
                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">خط الطول</label>
                            <input type="number" step="any" class="form-control" name="longitude" value="{{ old('longitude') }}">
                        </div>
                        <div class="col-12 animate__animated animate__fadeInUp">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label">نشط</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary animate__animated animate__pulse">حفظ</button>
                        <a href="{{ route('branches.index') }}" class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Choices('#employee-choices', {
                removeItemButton: true,
                placeholderValue: 'اختر الموظفين...',
                noResultsText: 'لا توجد نتائج',
            });
        });
    </script>
@endsection