{{-- resources/views/dashboard/categories/edit.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تعديل تصنيف - زهور')

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
    .drop-zone.dragover { background: #c7d2fe; border-color: #1e40af; }

    .image-preview {
        max-width: 220px;
        max-height: 220px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        border: 4px solid white;
    }

    .current-image {
        position: relative;
        display: inline-block;
    }

    .remove-image {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #f72585;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(247,37,133,0.4);
        transition: all 0.3s;
    }

    .remove-image:hover {
        transform: scale(1.15);
        background: #e0006b;
    }

    .color-preview {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        border: 5px solid white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        transition: all 0.3s;
    }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">التصنيفات /</span> تعديل تصنيف
    </h4>

    <div class="card shadow-lg animate__animated animate__zoomIn">
        <h5 class="card-header bg-primary text-white py-4">
            تعديل التصنيف: <strong>{{ $category->name }}</strong>
            <small class="opacity-75">({{ $category->code }})</small>
        </h5>

        <div class="card-body p-5">
            <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- معاينة الصورة الحالية + رفع جديدة -->
                <div class="text-center mb-5">
                    @if($category->image)
                        <div class="current-image d-inline-block mb-4" id="currentImageContainer">
                            <img src="{{ asset('storage/' . $category->image) }}" class="image-preview" id="currentImagePreview" alt="{{ $category->name }}">
                            <div class="remove-image" id="removeImageBtn" title="حذف الصورة">
                                <i class='bx bx-trash'></i>
                            </div>
                            <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                        </div>
                    @endif

                    <div class="drop-zone {{ $category->image ? 'mt-4' : '' }}" id="dropZone" style="{{ $category->image ? '' : '' }}">
                        <i class='bx bxs-cloud-upload' style="font-size: 4rem; color: #4361ee;"></i>
                        <p class="mt-3 mb-1 fw-bold">اسحب صورة جديدة هنا أو اضغط للرفع</p>
                        <small class="text-muted">PNG, JPG, WEBP • حتى 2MB</small>
                        <input type="file" name="image" id="imageInput" accept="image/*" hidden>
                    </div>

                    <img id="imagePreview" class="image-preview mt-4" style="display:none;" alt="معاينة الصورة الجديدة">
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">اسم التصنيف <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">كود التصنيف <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" name="code" value="{{ old('code', $category->code) }}" required>
                        @error('code') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">التصنيف الأب</label>
                        <select class="form-select form-select-lg" name="parent_id">
                            <option value="">-- تصنيف رئيسي --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">اللون المميز</label>
                        <div class="d-flex align-items-center gap-4">
                            <input type="color" class="form-control form-control-color" name="color"
                                   value="{{ old('color', $category->color) }}" style="width: 100px; height: 65px;">
                            <div class="color-preview" id="colorPreview"
                                 style="background-color: {{ old('color', $category->color) }};"></div>
                        </div>
                        @error('color') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" rows="4" name="description">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">التصنيف نشط</label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 d-flex gap-3 justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5 animate__animated animate__pulse">
                        <i class='bx bx-check'></i> تحديث التصنيف
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-lg px-5">
                        <i class='bx bx bx-arrow-back'></i> إلغاء
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
    const currentImageContainer = document.getElementById('currentImageContainer');
    const removeImageBtn = document.getElementById('removeImageBtn');
    const removeImageInput = document.getElementById('removeImageInput');
    const colorInput = document.querySelector('input[name="color"]');
    const colorPreview = document.getElementById('colorPreview');

    // Color Preview
    colorInput.addEventListener('input', () => {
        colorPreview.style.backgroundColor = colorInput.value;
    });

    // حذف الصورة الحالية
    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', () => {
            if (confirm('هل تريد حذف الصورة الحالية؟')) {
                currentImageContainer.style.display = 'none';
                removeImageInput.value = '1';
                dropZone.style.display = 'block';
                imagePreview.style.display = 'none';
            }
        });
    }

    // Drag & Drop + Click
    dropZone.onclick = () => imageInput.click();

    dropZone.ondragover = e => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    };

    dropZone.ondragleave = () => dropZone.classList.remove('dragover');

    dropZone.ondrop = e => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        if (e.dataTransfer.files[0]) {
            imageInput.files = e.dataTransfer.files;
            previewNewImage(e.dataTransfer.files[0]);
        }
    };

    imageInput.onchange = () => {
        if (imageInput.files[0]) {
            previewNewImage(imageInput.files[0]);
            if (currentImageContainer) {
                currentImageContainer.style.display = 'none';
            }
        }
    };

    function previewNewImage(file) {
        const reader = new FileReader();
        reader.onload = e => {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            dropZone.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection