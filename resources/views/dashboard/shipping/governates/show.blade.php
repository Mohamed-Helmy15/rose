{{-- resources/views/dashboard/shipping/governates/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', '{{ $governate->name }} - زهور')

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
        <span class="text-muted fw-light">الشحن / المحافظات /</span> {{ $governate->name }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">{{ $governate->name }}</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                    <div class="section-content">
                        <h6 class="section-title">الاسم</h6>
                        <p>{{ $governate->name }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                    <div class="section-content">
                        <h6 class="section-title">الحالة</h6>
                        <p><span class="badge {{ $governate->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $governate->is_active ? 'نشط' : 'معطل' }}</span></p>
                    </div>
                </div>
                <div class="col-md-12 mb-3 animate__animated animate__fadeInUp">
                    <div class="section-content">
                        <h6 class="section-title">المدن ({{ $governate->cities->count() }})</h6>
                        @if($governate->cities->count())
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>الاسم</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($governate->cities as $city)
                                            <tr>
                                                <td>{{ $city->name }}</td>
                                                <td><span class="badge {{ $city->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $city->is_active ? 'نشط' : 'معطل' }}</span></td>
                                                <td>
                                                    <a href="{{ route('shipping.cities.show', $city) }}" class="btn btn-sm btn-primary">عرض</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">لا توجد مدن</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('shipping.governates.edit', $governate) }}" class="btn btn-primary animate__animated animate__pulse">تعديل</a>
                <a href="{{ route('shipping.governates.index') }}" class="btn btn-secondary animate__animated animate__pulse">رجوع</a>
            </div>
        </div>
    </div>
</div>
@endsection