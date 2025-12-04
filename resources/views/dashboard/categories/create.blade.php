@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة تصنيف جديد - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .drop-zone {
        border: 3px dashed #4361ee;
        border-radius: 16px;
        padding: 50px 20px;
        text-align: center;
        background: #f8f9ff;
        cursor: pointer;
        transition: all 0.3s;
    }
    .drop-zone:hover { background: #e0e7ff; }
    .image-preview { max-width: 200px; max-height: 200px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
    .color-preview { width: 70px; height: 70px; border-radius: 16px; border: 5px solid white; box-shadow: 0 8px 25px rgba(0,0,0,0.2); }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">التصنيفات /</span> إضافة تصنيف جديد</h4>

    <div class="card shadow-lg animate__animated animate__zoomIn">
        <h5 class="card-header bg-primary text-white py-4">إضافة تصنيف جديد</h5>
        <div class="card-body p-5">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="text-center mb-5">
                    <div class="drop-zone" id="dropZone">
                        <i class='bx bxs-cloud-upload' style="font-size: 4rem; color: #4361ee;"></i>
                        <p class="mt-3 mb-1 fw-bold">اسحب الصورة هنا أو اضغط للرفع</p>
                        <small class="text-muted">PNG, JPG, WEBP • حتى 2MB</small>
                        <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                    </div>
                    <img id="imagePreview" class="image-preview mt-4" style="display:none;" alt="معاينة">
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">اسم التصنيف <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">كود التصنيف <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="code" value="{{ old('code') }}" required>
                        @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">التصنيف الأب</label>
                        <select class="form-select form-select-lg" name="parent_id">
                            <option value="">-- تصنيف رئيسي --</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اللون المميز</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" class="form-control form-control-color" name="color" value="{{ old('color', '#4361ee') }}" style="width: 100px; height: 60px;">
                            <div class="color-preview" id="colorPreview" style="background-color: {{ old('color', '#4361ee') }};"></div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" rows="4" name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">التصنيف نشط</label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-3 justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class='bx bx-check'></i> حفظ التصنيف
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-lg px-5">
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
    const dropZone = document.getElementById('dropZone');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const colorInput = document.querySelector('input[name="color"]');
    const colorPreview = document.getElementById('colorPreview');

    dropZone.onclick = () => imageInput.click();

    dropZone.ondragover = e => { e.preventDefault(); dropZone.style.background = '#e0e7ff'; };
    dropZone.ondragleave = () => dropZone.style.background = '#f8f9ff';
    dropZone.ondrop = e => {
        e.preventDefault();
        dropZone.style.background = '#f8f9ff';
        if (e.dataTransfer.files[0]) {
            imageInput.files = e.dataTransfer.files;
            previewImage(e.dataTransfer.files[0]);
        }
    };

    imageInput.onchange = e => {
        if (e.target.files[0]) previewImage(e.target.files[0]);
    };

    function previewImage(file) {
        const reader = new FileReader();
        reader.onload = e => {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            dropZone.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    colorInput.oninput = () => colorPreview.style.backgroundColor = colorInput.value;
});
</script>
@endsection