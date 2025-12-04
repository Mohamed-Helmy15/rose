{{-- resources/views/dashboard/branches/edit.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تعديل فرع - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        .form-control,
        .form-select,
        .choices__inner {
            border-radius: 10px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .choices__list--dropdown, .choices__list[aria-expanded] {
            position: relative !important;
        }
        
        .form-control:focus,
        .form-select:focus,
        .choices__inner:focus {
            border-color: #4361ee !important;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25) !important;
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #00c6ff);
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #0099cc);
        }
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #adb5bd);
            border: none;
            transition: background 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(45deg, #5a6268, #868e96);
        }
        .text-danger {
            font-size: 0.875rem;
        }
        .choices__list--multiple .choices__item {
            background: #4361ee;
            border-color: #4361ee;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">الفروع /</span> تعديل فرع
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">تعديل الفرع: <strong>{{ $branch->name }}</strong> <small class="text-muted">({{ $branch->code }})</small></h5>
            <div class="card-body">
                <form action="{{ route('branches.update', $branch) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- الاسم --}}
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <label class="form-label">اسم الفرع</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $branch->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- الكود --}}
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <label class="form-label">كود الفرع</label>
                            <input type="text" class="form-control" name="code" value="{{ old('code', $branch->code) }}" required>
                            @error('code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- مدير الفرع --}}
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <label class="form-label">مدير الفرع</label>
                            <select class="form-select" name="manager_id">
                                <option value="">-- اختر مدير --</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}" 
                                        {{ old('manager_id', $branch->manager_id) == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('manager_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- الهاتف --}}
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <label class="form-label">الهاتف</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $branch->phone) }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- الموظفين (Multiple Select مع Choices.js) --}}
                        <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                            <label class="form-label">الموظفين</label>
                            <select name="employee_ids[]" multiple class="form-select" id="employee-choices">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ $branch->employees->contains($employee->id) || in_array($employee->id, old('employee_ids', [])) ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">يمكنك اختيار أكثر من موظف</small>
                            @error('employee_ids')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- العنوان --}}
                        <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                            <label class="form-label">العنوان</label>
                            <textarea class="form-control" name="address" rows="2">{{ old('address', $branch->address) }}</textarea>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- خط العرض وخط الطول --}}
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <label class="form-label">خط العرض (Latitude)</label>
                            <input type="number" step="any" class="form-control" name="latitude" value="{{ old('latitude', $branch->latitude) }}">
                            @error('latitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <label class="form-label">خط الطول (Longitude)</label>
                            <input type="number" step="any" class="form-control" name="longitude" value="{{ old('longitude', $branch->longitude) }}">
                            @error('longitude')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- الحالة (نشط/معطل) --}}
                        <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                    {{ old('is_active', $branch->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">الفرع نشط</label>
                            </div>
                            @error('is_active')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- الأزرار --}}
                    <div class="mt-4 d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary animate__animated animate__pulse">
                            <i class='bx bx-check'></i> تحديث الفرع
                        </button>
                        <a href="{{ route('branches.index') }}" class="btn btn-secondary animate__animated animate__pulse">
                            <i class='bx bx-arrow-back'></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('employee-choices');
            if (select) {
                new Choices(select, {
                    removeItemButton: true,
                    placeholderValue: 'اختر الموظفين...',
                    noResultsText: 'لا توجد نتائج',
                    noChoicesText: 'لا يوجد موظفين',
                    itemSelectText: 'اضغط للاختيار',
                    searchPlaceholderValue: 'ابحث بالاسم...',
                    shouldSort: false,
                });
            }
        });
    </script>
@endsection