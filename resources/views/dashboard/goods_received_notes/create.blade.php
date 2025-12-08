{{-- resources/views/dashboard/goods_received_notes/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة إيصال استلام جديد - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .form-control, .form-select { border-radius: 10px; }
    .form-control:focus, .form-select:focus { border-color: #4361ee; box-shadow: 0 0 0 0.2rem rgba(67,97,238,0.25); }
    .item-row { background: #f8f9fa; padding: 1rem; border-radius: 12px; margin-bottom: 1rem; }
    .item-row:hover { background: #e9ecef; }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">إيصالات الاستلام /</span> إضافة إيصال استلام جديد
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header bg-primary text-white py-4">إضافة إيصال استلام جديد</h5>
        <div class="card-body p-5">
            <form action="{{ route('goods-received-notes.store') }}" method="POST">
                @csrf

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">أمر الشراء <span class="text-danger">*</span></label>
                        <select name="purchase_order_id" class="form-select" id="po-select" required>
                            <option value="">اختر أمر الشراء</option>
                            @foreach ($purchaseOrders as $po)
                                <option value="{{ $po->id }}">#{{ $po->id }} - {{ $po->supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الاستلام <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="received_date" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المخزن <span class="text-danger">*</span></label>
                        <select name="warehouse_id" class="form-select" required>
                            <option value="">اختر المخزن</option>
                            @foreach (\App\Models\Warehouse::active()->get() as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }} ({{ $warehouse->branch->name }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">ملاحظات</label>
                    <textarea class="form-control" rows="3" name="notes" placeholder="ملاحظات اختيارية..."></textarea>
                </div>

                <h5 class="mb-4 text-primary">المنتجات المستلمة</h5>
                <div id="items-container">
                    <!-- سيتم ملؤها ديناميكيًا عبر JS -->
                    <div class="text-center text-muted py-5">
                        <i class='bx bxs-package fs-1'></i>
                        <p class="mt-3">اختر أمر الشراء لعرض المنتجات</p>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-3 justify-content-end">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class='bx bx-check-circle'></i> تأكيد الاستلام وإضافة الباتشات
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
    document.getElementById('po-select').addEventListener('change', async function() {
        const poId = this.value;
        const container = document.getElementById('items-container');

        if (!poId) {
            container.innerHTML = `<div class="text-center text-muted py-5"><p>اختر أمر الشراء</p></div>`;
            return;
        }

        try {
            const response = await fetch(`/goods-received-notes/po/${poId}/items`);
            const items = await response.json();

            if (items.length === 0 || items.every(i => i.remaining_quantity <= 0)) {
                container.innerHTML = `<div class="alert alert-info text-center">تم استلام كل الكميات لهذا الأمر</div>`;
                return;
            }

            container.innerHTML = '';
            items.forEach((item, i) => {
                if (item.remaining_quantity <= 0) return;

                const row = document.createElement('div');
                row.className = 'item-row border-start border-success border-4';
                row.innerHTML = `
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="d-block fw-bold">${item.name}</label>
                            <small class="text-muted d-block">مطلوب: ${item.ordered_quantity}</small>
                            <small class="text-success d-block">مستلم: ${item.received_quantity} | متبقي: <strong>${item.remaining_quantity}</strong></small>
                            <input type="hidden" name="items[${i}][id]" value="${item.id}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="items[${i}][quantity]" class="form-control" 
                                   min="0" max="${item.remaining_quantity}" value="${item.remaining_quantity}" required>
                            <small class="text-danger">الحد الأقصى: ${item.remaining_quantity}</small>
                        </div>
                        <div class="col-md-2">
                            <select name="items[${i}][quality_status]" class="form-select" required>
                                <option value="accepted" selected>مقبول</option>
                                <option value="rejected">مرفوض</option>
                                <option value="partial">جزئي</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="items[${i}][lot_number]" class="form-control" placeholder="رقم الدفعة">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="items[${i}][expiry_date]" class="form-control">
                        </div>
                    </div>
                `;
                container.appendChild(row);
            });
        } catch (err) {
            container.innerHTML = `<div class="alert alert-danger">حدث خطأ في تحميل البيانات</div>`;
        }
    });
</script>
@endsection