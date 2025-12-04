{{-- resources/views/dashboard/shipping/rates/show.blade.php --}}
@extends('layouts.contentNavbarLayout')

@section('title', 'سعر شحن - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .section-content { background: #f8f9fa; padding: 15px; border-radius: 10px; }
    .price-tag { font-size: 2rem; font-weight: 700; color: #10b981; margin: 0; }
    .btn-primary { background: linear-gradient(45deg, #4361ee, #5e7bff); border: none; }
    .btn-primary:hover { background: linear-gradient(45deg, #324bcb, #4361ee); }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">الشحن / أسعار الشحن /</span> {{ $shippingRate->location->name }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header d-flex align-items-center gap-2">
            <i class='bx bx-dollar text-success'></i>
            سعر شحن: {{ $shippingRate->location->name }}
        </h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                    <div class="section-content">
                        <h6 class="section-title">المكان</h6>
                        <p class="mb-1">{{ $shippingRate->location->name }}</p>
                        <p class="text-muted small">
                            {{ $shippingRate->location->city->name }}، {{ $shippingRate->location->city->governate->name }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                    <div class="section-content">
                        <h6 class="section-title">السعر</h6>
                        <p class="price-tag">{{ $shippingRate->rate }} جنيه</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                    <div class="section-content">
                        <h6 class="section-title">الحالة</h6>
                        <p><span class="badge {{ $shippingRate->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $shippingRate->is_active ? 'نشط' : 'معطل' }}</span></p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('shipping.rates.edit', $shippingRate) }}" class="btn btn-primary animate__animated animate__pulse">تعديل</a>
                <a href="{{ route('shipping.rates.index') }}" class="btn btn-secondary animate__animated animate__pulse">رجوع</a>
            </div>
        </div>
    </div>
</div>
@endsection