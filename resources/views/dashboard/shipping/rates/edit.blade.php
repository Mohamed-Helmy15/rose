{{-- resources/views/dashboard/shipping/rates/edit.blade.php --}}
@extends('layouts.contentNavbarLayout')

@section('title', 'تعديل سعر شحن - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .form-control, .form-select { border-radius: 10px; }
    .form-control:focus { border-color: #4361ee; box-shadow: 0 0 0 0.2rem rgba(67,97,238,0.25); }
    .btn-primary { background: linear-gradient(45deg, #4361ee, #5e7bff); border: none; }
    .btn-primary:hover { background: linear-gradient(45deg, #324bcb, #4361ee); }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">الشحن / أسعار الشحن /</span> تعديل سعر شحن
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">تعديل سعر الشحن</h5>
        <div class="card-body">
            <form action="{{ route('shipping.rates.update', $shippingRate) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                        <label class="form-label">المكان</label>
                        <select class="form-select" name="location_id" required>
                            <option value="">اختر مكانًا</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ old('location_id', $shippingRate->location_id) == $loc->id ? 'selected' : '' }}>
                                    {{ $loc->name }} ({{ $loc->city->name }}, {{ $loc->city->governate->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('location_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                        <label class="form-label">السعر (جنيه)</label>
                        <input type="number" class="form-control" name="rate" step="0.01" value="{{ old('rate', $shippingRate->rate) }}" required>
                        @error('rate') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $shippingRate->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">نشط</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary animate__animated animate__pulse">تحديث</button>
                    <a href="{{ route('shipping.rates.index') }}" class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection