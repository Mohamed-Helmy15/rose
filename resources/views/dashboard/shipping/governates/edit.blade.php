{{-- resources/views/dashboard/shipping/governates/edit.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تعديل {{ $governate->name }} - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .form-control { border-radius: 10px; }
    .form-control:focus { border-color: #4361ee; box-shadow: 0 0 0 0.2rem rgba(67,97,238,0.25); }
    .btn-primary { background: linear-gradient(45deg, #4361ee, #5e7bff); border: none; }
    .btn-primary:hover { background: linear-gradient(45deg, #324bcb, #4361ee); }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">الشحن / المحافظات /</span> تعديل محافظة
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">تعديل المحافظة</h5>
        <div class="card-body">
            <form action="{{ route('shipping.governates.update', $governate) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                        <label class="form-label">الاسم</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $governate->name) }}" required>
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $governate->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">نشط</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary animate__animated animate__pulse">تحديث</button>
                    <a href="{{ route('shipping.governates.index') }}" class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection