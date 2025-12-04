{{-- resources/views/dashboard/suppliers/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة مورد جديد - زهور')

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
        <span class="text-muted fw-light">الموردين /</span> إضافة مورد جديد
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header bg-primary text-white py-4">إضافة مورد جديد</h5>
        <div class="card-body p-5">
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInLeft">
                        <label class="form-label">اسم المورد <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInRight">
                        <label class="form-label">اسم الاتصال</label>
                        <input type="text" class="form-control form-control-lg" name="contact_name" value="{{ old('contact_name') }}">
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInLeft">
                        <label class="form-label">الهاتف <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInRight">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="col-12 animate__animated animate__fadeInUp">
                        <label class="form-label">العنوان</label>
                        <textarea class="form-control" rows="3" name="address">{{ old('address') }}</textarea>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInLeft">
                        <label class="form-label">رقم الضريبة</label>
                        <input type="text" class="form-control" name="tax_number" value="{{ old('tax_number') }}">
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInRight">
                        <label class="form-label">تفاصيل البنك</label>
                        <input type="text" class="form-control" name="bank_details" value="{{ old('bank_details') }}">
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInLeft">
                        <label class="form-label">شروط الدفع</label>
                        <input type="text" class="form-control" name="payment_terms" value="{{ old('payment_terms', settings('default_payment_terms', 'Net 30')) }}">
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInRight">
                        <label class="form-label">زمن التسليم (أيام)</label>
                        <input type="number" class="form-control" name="delivery_time_days" value="{{ old('delivery_time_days', settings('default_delivery_time', 7)) }}">
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                            <label class="form-check-label">المورد نشط</label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-3 justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5 animate__animated animate__pulse">
                        <i class='bx bx-check'></i> حفظ المورد
                    </button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-lg px-5">
                        <i class='bx bx-arrow-back'></i> إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection