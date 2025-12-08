{{-- resources/views/dashboard/purchase_orders/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة أمر شراء جديد - زهور')

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
            transition: all 0.3s ease;
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
        }

        .product-row {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .text-danger {
            font-size: 0.875rem;
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

        .text-danger {
            font-size: 0.875rem;
        }

        .choices__list--dropdown,
        .choices__list[aria-expanded] {
            position: relative !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">أوامر الشراء /</span> إضافة أمر شراء جديد
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header bg-primary text-white py-4">إضافة أمر شراء جديد</h5>
            <div class="card-body p-5">
                <form action="{{ route('purchase-orders.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">المورد <span class="text-danger">*</span></label>
                            <select name="supplier_id" class="form-select" id="supplier-select" required>
                                <option value="">اختر مورد</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">تاريخ الطلب <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="order_date"
                                value="{{ old('order_date', now()->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">تاريخ التسليم المتوقع <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="expected_delivery_date"
                                value="{{ old('expected_delivery_date', now()->addDays(7)->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-12 animate__animated animate__fadeInUp">
                            <label class="form-label">الملاحظات</label>
                            <textarea class="form-control" rows="3" name="notes">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <h5 class="mt-4">المنتجات</h5>
                    <div id="products-container">
                        <div class="product-row">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <select name="products[0][id]" class="form-select product-select">
                                        <option value="">اختر منتج</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}">
                                                {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="products[0][quantity]" class="form-control quantity"
                                        placeholder="كمية" min="1">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" step="0.01" name="products[0][price]"
                                        class="form-control price" placeholder="سعر">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-product"><i
                                            class='bx bx-trash'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-product" class="btn btn-outline-primary mt-3"><i
                            class='bx bxs-plus-circle'></i> إضافة منتج</button>

                    <div class="mt-5 d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5 animate__animated animate__pulse">
                            <i class='bx bx-check'></i> حفظ أمر الشراء
                        </button>
                        <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary btn-lg px-5">
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
        document.addEventListener('DOMContentLoaded', () => {
            new Choices('#supplier-select');

            let productIndex = 1;

            document.getElementById('add-product').addEventListener('click', () => {
                const container = document.getElementById('products-container');
                const row = document.createElement('div');
                row.className = 'product-row';
                row.innerHTML = `
            <div class="row g-3">
                <div class="col-md-4">
                    <select name="products[${productIndex}][id]" class="form-select product-select">
                        <option value="">اختر منتج</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="products[${productIndex}][quantity]" class="form-control quantity" placeholder="كمية" min="1">
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="products[${productIndex}][price]" class="form-control price" placeholder="سعر">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-product"><i class='bx bx-trash'></i></button>
                </div>
            </div>
        `;
                container.appendChild(row);
                productIndex++;
            });

            document.getElementById('products-container').addEventListener('change', (e) => {
                if (e.target.classList.contains('product-select')) {
                    const price = e.target.options[e.target.selectedIndex].dataset.price || '';
                    e.target.closest('.row').querySelector('.price').value = price;
                }
            });

            document.getElementById('products-container').addEventListener('click', (e) => {
                if (e.target.closest('.remove-product')) {
                    e.target.closest('.product-row').remove();
                }
            });
        });
    </script>
@endsection
