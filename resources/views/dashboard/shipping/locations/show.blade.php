{{-- resources/views/dashboard/shipping/locations/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', '{{ $location->name }} - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .section-content { background: #f8f9fa; padding: 15px; border-radius: 10px; }
    .btn-primary { background: linear-gradient(45deg, #4361ee, #5e7bff); border: none; }
    .btn-primary:hover { background: linear-gradient(45deg, #324bcb, #4361ee); }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">الشحن / الأماكن /</span> {{ $location->name }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">{{ $location->name }}</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                    <div class="section-content">
                        <h6 class="section-title">الاسم</h6>
                        <p>{{ $location->name }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                    <div class="section-content">
                        <h6 class="section-title">المدينة</h6>
                        <p>{{ $location->city->name }} <span class="text-muted">({{ $location->city->governate->name }})</span></p>
                    </div>
                </div>
                <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                    <div class="section-content">
                        <h6 class="section-title">الحالة</h6>
                        <p><span class="badge {{ $location->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $location->is_active ? 'نشط' : 'معطل' }}</span></p>
                    </div>
                </div>
                <div class="col-md-12 mb-3 animate__animated animate__fadeInUp">
                    <div class="section-content">
                        <h6 class="section-title">أسعار الشحن ({{ $location->shippingRates->count() }})</h6>
                        @if($location->shippingRates->count())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>السعر</th>
                                            <th>نشط</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($location->shippingRates as $rate)
                                            <tr>
                                                <td>{{ $rate->rate }} جنيه</td>
                                                <td><span class="badge {{ $rate->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $rate->is_active ? 'نشط' : 'معطل' }}</span></td>
                                                <td>
                                                    <a href="{{ route('shipping.rates.show', $rate) }}" class="btn btn-sm btn-primary">عرض</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">لا توجد أسعار شحن</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('shipping.locations.edit', $location) }}" class="btn btn-primary animate__animated animate__pulse">تعديل</a>
                <a href="{{ route('shipping.locations.index') }}" class="btn btn-secondary animate__animated animate__pulse">رجوع</a>
            </div>
        </div>
    </div>
</div>
@endsection