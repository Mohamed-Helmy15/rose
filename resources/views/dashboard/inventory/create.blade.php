@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة مخزن جديد - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
<style>
    :root {
        --primary: #4361ee;
        --danger: #f72585;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    .form-control, .form-select, .choices__inner {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus, .choices__inner:focus {
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
    .drop-zone {
        border: 3px dashed #4361ee;
        border-radius: 16px;
        padding: 40px;
        text-align: center;
        background: #f8f9ff;
        cursor: pointer;
        transition: all 0.3s;
    }
    .drop-zone:hover { background: #e0e7ff; }
    .image-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        margin: 5px;
    }
    .color-preview {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        border: 5px solid white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .text-danger { font-size: 0.875rem; }

    .choices__list--dropdown,
    .choices__list[aria-expanded] {
        position: relative !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">المخازن /</span> إضافة مخزن جديد
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header bg-primary text-white py-4">إضافة مخزن جديد</h5>
        <div class="card-body p-5">
            <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInLeft">
                        <label class="form-label">اسم المخزن <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="name"
                               value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInRight">
                        <label class="form-label">العنوان</label>
                        <input type="text" class="form-control" name="address"
                               value="{{ old('address') }}">
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    @if(settings('multi_branch'))
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">الفرع</label>
                            <select name="branch_id" class="form-select" required>
                                <option value="">-- اختر الفرع --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_refrigerated" value="1" checked>
                            <label class="form-check-label">مخزن مبرد (للزهور الفريش)</label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-3 justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5 animate__animated animate__pulse">
                        <i class='bx bx-check'></i> حفظ المخزن
                    </button>
                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary btn-lg px-5">
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
        // No Choices.js needed for this view, but keeping for consistency if added later
    });
</script>
@endsection