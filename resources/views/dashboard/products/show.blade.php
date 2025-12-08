{{-- resources/views/dashboard/products/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل المنتج - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
    .product-image-large { width: 100%; max-height: 400px; object-fit: cover; border-radius: 16px; box-shadow: 0 15px 40px rgba(0,0,0,0.2); }
    .info-box { background: #f8f9fa; padding: 20px; border-radius: 12px; }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">المنتجات /</span> {{ $product->name }}
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header bg-primary text-white">
            {{ $product->name }} <small class="opacity-80">(SKU: {{ $product->sku }})</small>
        </h5>
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
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="text-muted">سعر البيع</h6>
                                <p class="fs-3 fw-bold text-primary">{{ number_format($product->priceWithTax(), 2) }} ج.م</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="text-muted">الكمية المتاحة</h6>
                                @php $available = $product->getAvailableQuantityAttribute(); @endphp
                                <p class="fs-3 fw-bold {{ $available <= ($product->reorder_level ?? 10) ? 'text-danger' : 'text-success' }}">
                                    {{ $available }} قطعة
                                    @if($available <= ($product->reorder_level ?? 10))
                                        <span class="badge bg-danger ms-2">منخفض!</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="text-muted">التصنيفات</h6>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach($product->categories as $cat)
                                        <span class="badge bg-light text-dark">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <h6 class="text-muted">الحالة</h6>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $product->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-box">
                                <h6 class="text-muted">الوصف</h6>
                                <p>{{ $product->description ?? 'لا يوجد وصف' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">عودة</a>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">تعديل المنتج</a>
            </div>
        </div>
    </div>
</div>
@endsection