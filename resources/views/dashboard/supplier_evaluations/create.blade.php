{{-- resources/views/dashboard/supplier_evaluations/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة تقييم مورد جديد - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
        .form-select {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
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
        }

        .text-danger {
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">تقييمات الموردين /</span> إضافة تقييم جديد
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header bg-primary text-white py-4">إضافة تقييم مورد جديد</h5>
            <div class="card-body p-5">
                <form action="{{ route('supplier-evaluations.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">المورد <span class="text-danger">*</span></label>
                            <select name="supplier_id" class="form-select" required>
                                <option value="">اختر مورد</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">تاريخ التقييم <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="evaluation_date"
                                value="{{ old('evaluation_date', now()->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">التقييم (0-5) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control" name="rating" min="0"
                                max="5" required>
                        </div>

                        <div class="col-12 animate__animated animate__fadeInUp">
                            <label class="form-label">التعليقات</label>
                            <textarea class="form-control" rows="4" name="comments">{{ old('comments') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-5 d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5 animate__animated animate__pulse">
                            <i class='bx bx-check'></i> حفظ التقييم
                        </button>
                        <a href="{{ route('supplier-evaluations.index') }}" class="btn btn-secondary btn-lg px-5">
                            <i class='bx bx-arrow-back'></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
