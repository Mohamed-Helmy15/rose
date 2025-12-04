{{-- resources/views/dashboard/products/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل المنتج - زهور')

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
    .section-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        transition: background 0.3s ease;
    }
    .section-content:hover {
        background: #e9ecef;
    }
    .product-image-large {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">المنتجات /</span> {{ $product->name }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">{{ $product->name }} <small class="text-muted">(SKU: {{ $product->sku }})</small></h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 text-center mb-4">
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/'.$product->primaryImage->image_path) }}" class="product-image-large" alt="{{ $product->name }}">
                    @else
                        <div class="product-image-large d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, {{ $product->color }}20, {{ $product->color }}80);">
                            <i class='bx bxs-florist' style="font-size: 6rem; color: {{ $product->color }};"></i>
                        </div>
                    @endif
                </div>

                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <div class="section-content">
                                <h6 class="section-title">سعر البيع</h6>
                                <p class="fs-4 fw-bold text-primary">{{ number_format($product->priceWithTax(), 2) }} {{ settings('currency') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <div class="section-content">
                                <h6 class="section-title">الكمية المتاحة</h6>
                                <p class="{{ $product->isLowStock() ? 'text-danger' : 'text-success' }} fs-4 fw-bold">
                                    {{ $product->stock_quantity }} قطعة
                                    @if($product->isLowStock()) <span class="badge bg-danger ms-2">منخفض!</span> @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <div class="section-content">
                                <h6 class="section-title">التصنيفات</h6>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($product->categories as $cat)
                                        <span class="badge bg-light text-dark">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <div class="section-content">
                                <h6 class="section-title">الحالة</h6>
                                <p>{{ $product->is_active ? 'نشط' : 'معطل' }}</p>
                            </div>
                        </div>
                        <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                            <div class="section-content">
                                <h6 class="section-title">الوصف</h6>
                                <p>{{ $product->description ?? 'لا يوجد وصف' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-secondary animate__animated animate__pulse">عودة</a>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary animate__animated animate__pulse">تعديل</a>
            </div>
        </div>
    </div>
</div>
@endsection