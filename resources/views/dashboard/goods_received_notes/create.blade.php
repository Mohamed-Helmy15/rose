{{-- resources/views/dashboard/goods_received_notes/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة إيصال استلام جديد - زهور')

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

        .item-row {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .text-danger {
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">إيصالات الاستلام /</span> إضافة إيصال استلام جديد
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header bg-primary text-white py-4">إضافة إيصال استلام جديد</h5>
            <div class="card-body p-5">
                <form action="{{ route('goods-received-notes.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">أمر الشراء <span class="text-danger">*</span></label>
                            <select name="purchase_order_id" class="form-select" id="po-select" required>
                                <option value="">اختر أمر شراء</option>
                                @foreach ($purchaseOrders as $po)
                                    <option value="{{ $po->id }}">#{{ $po->id }} - {{ $po->supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">تاريخ الاستلام <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="received_date"
                                value="{{ old('received_date', now()->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-12 animate__animated animate__fadeInUp">
                            <label class="form-label">الملاحظات</label>
                            <textarea class="form-control" rows="3" name="notes">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <h5 class="mt-4">المنتجات المستلمة</h5>
                    <div id="items-container">
                        <!-- Will be populated via JS based on PO selection -->
                    </div>

                    <div class="mt-5 d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5 animate__animated animate__pulse">
                            <i class='bx bx-check'></i> حفظ إيصال الاستلام
                        </button>
                        <a href="{{ route('goods-received-notes.index') }}" class="btn btn-secondary btn-lg px-5">
                            <i class='bx bx-arrow-back'></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const poSelect = document.getElementById('po-select');
            const itemsContainer = document.getElementById('items-container');

            poSelect.addEventListener('change', async () => {
                const poId = poSelect.value;
                if (!poId) return;

                // Fetch PO products via AJAX
                const response = await fetch(
                    `/purchase-orders/${poId}/products`); // Assume an API route for this
                const products = await response.json();

                itemsContainer.innerHTML = '';
                products.forEach((product, index) => {
                    const row = document.createElement('div');
                    row.className = 'item-row';
                    row.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-3">
                        <label>${product.name}</label>
                        <input type="hidden" name="items[${index}][id]" value="${product.id}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="items[${index}][quantity]" class="form-control" placeholder="كمية مستلمة" min="0" max="${product.pivot.quantity}">
                    </div>
                    <div class="col-md-3">
                        <select name="items[${index}][quality_status]" class="form-select">
                            <option value="accepted">مقبول</option>
                            <option value="rejected">مرفوض</option>
                            <option value="partial">جزئي</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="items[${index}][lot_number]" class="form-control" placeholder="رقم الدفعة">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="items[${index}][expiry_date]" class="form-control">
                    </div>
                </div>
            `;
                    itemsContainer.appendChild(row);
                });
            });
        });
    </script>
@endsection
