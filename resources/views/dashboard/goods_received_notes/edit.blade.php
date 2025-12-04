{{-- resources/views/dashboard/goods_received_notes/edit.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تعديل إيصال استلام - زهور')

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
            <span class="text-muted fw-light">إيصالات الاستلام /</span> تعديل إيصال استلام
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header bg-primary text-white py-4">تعديل إيصال الاستلام #{{ $goodsReceivedNote->id }}</h5>
            <div class="card-body p-5">
                <form action="{{ route('goods-received-notes.update', $goodsReceivedNote) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">أمر الشراء <span class="text-danger">*</span></label>
                            <select name="purchase_order_id" class="form-select" required>
                                @foreach ($purchaseOrders as $po)
                                    <option value="{{ $po->id }}"
                                        {{ $goodsReceivedNote->purchase_order_id == $po->id ? 'selected' : '' }}>
                                        #{{ $po->id }} - {{ $po->supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">تاريخ الاستلام <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="received_date"
                                value="{{ old('received_date', $goodsReceivedNote->received_date->format('Y-m-d')) }}"
                                required>
                        </div>

                        <div class="col-12 animate__animated animate__fadeInUp">
                            <label class="form-label">الملاحظات</label>
                            <textarea class="form-control" rows="3" name="notes">{{ old('notes', $goodsReceivedNote->notes) }}</textarea>
                        </div>
                    </div>

                    <h5 class="mt-4">المنتجات المستلمة</h5>
                    <div id="items-container">
                        @foreach ($selectedItems as $index => $selected)
                            <div class="item-row">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label>{{ $products->find($selected['id'])->name }}</label>
                                        <input type="hidden" name="items[{{ $index }}][id]"
                                            value="{{ $selected['id'] }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="items[{{ $index }}][quantity]"
                                            class="form-control" value="{{ $selected['quantity'] }}" min="0">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="items[{{ $index }}][quality_status]" class="form-select">
                                            <option value="accepted"
                                                {{ $selected['quality_status'] == 'accepted' ? 'selected' : '' }}>مقبول
                                            </option>
                                            <option value="rejected"
                                                {{ $selected['quality_status'] == 'rejected' ? 'selected' : '' }}>مرفوض
                                            </option>
                                            <option value="partial"
                                                {{ $selected['quality_status'] == 'partial' ? 'selected' : '' }}>جزئي
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="items[{{ $index }}][lot_number]"
                                            class="form-control" value="{{ $selected['lot_number'] }}"
                                            placeholder="رقم الدفعة">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="items[{{ $index }}][expiry_date]"
                                            class="form-control"
                                            value="{{ $selected['expiry_date'] ? \Carbon\Carbon::parse($selected['expiry_date'])->format('Y-m-d') : '' }}">

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5 animate__animated animate__pulse">
                            <i class='bx bx-check'></i> تحديث إيصال الاستلام
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
