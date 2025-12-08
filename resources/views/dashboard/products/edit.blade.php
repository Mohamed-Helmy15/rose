{{-- resources/views/dashboard/products/edit.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تعديل منتج - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .form-control,
        .form-select,
        .choices__inner {
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .drop-zone {
            border: 3px dashed #4361ee;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            background: #f8f9ff;
            cursor: pointer;
        }

        .drop-zone:hover {
            background: #e0e7ff;
        }

        .image-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            border: 4px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            margin: 5px;
        }

        .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #f72585;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .color-preview {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            border: 5px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">المنتجات /</span> تعديل منتج
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header bg-primary text-white py-4">
                تعديل المنتج: <strong>{{ $product->name }}</strong>
                <small class="opacity-80">(SKU: {{ $product->sku }})</small>
            </h5>

            <div class="card-body p-5">
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <!-- الصور الحالية -->
                    <div class="text-center mb-5">
                        <div class="d-flex flex-wrap justify-content-center" id="currentImages">
                            @foreach ($product->images as $image)
                                <div class="position-relative" style="margin: 8px;">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="image-preview"
                                        alt="صورة" data-id="{{ $image->id }}">
                                    <span class="remove-image">×</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="drop-zone mt-4" id="dropZone">
                            <i class='bx bxs-cloud-upload' style="font-size: 4rem; color: #4361ee;"></i>
                            <p class="mt-3 fw-bold">إضافة صور جديدة</p>
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*" hidden>
                        </div>
                        <div id="imagePreviewContainer" class="d-flex flex-wrap justify-content-center mt-4"></div>
                    </div>


                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="name"
                                value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">سعر البيع <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control form-control-lg" name="price"
                                value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">سعر التكلفة</label>
                            <input type="number" step="0.01" class="form-control" name="cost_price"
                                value="{{ old('cost_price', $product->cost_price) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">حد إعادة الطلب</label>
                            <input type="number" class="form-control" name="reorder_level"
                                value="{{ old('reorder_level', $product->reorder_level) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">اللون المميز</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" class="form-control form-control-color" name="color"
                                    value="{{ old('color', $product->color) }}">
                                <div class="color-preview" id="colorPreview"
                                    style="background-color: {{ old('color', $product->color) }};"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">التصنيفات <span class="text-danger">*</span></label>
                            <select name="category_ids[]" multiple class="form-select" id="category-choices" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, $productCategories) ? 'selected' : '' }}>
                                        {{ $category->full_name ?? $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" rows="4" name="description">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label">المنتج نشط</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class='bx bx-check'></i> تحديث المنتج
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg px-5">
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
            new Choices('#category-choices', {
                removeItemButton: true,
                placeholderValue: 'اختر التصنيفات...'
            });

            const dropZone = document.getElementById('dropZone');
            const imageInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const currentImages = document.getElementById('currentImages');
            const colorInput = document.querySelector('input[name="color"]');
            const colorPreview = document.getElementById('colorPreview');

            colorInput.addEventListener('input', () => colorPreview.style.backgroundColor = colorInput.value);

            dropZone.onclick = () => imageInput.click();
            dropZone.ondragover = e => {
                e.preventDefault();
                dropZone.style.background = '#e0e7ff';
            };
            dropZone.ondragleave = () => dropZone.style.background = '#f8f9ff';
            dropZone.ondrop = e => {
                e.preventDefault();
                dropZone.style.background = '#f8f9ff';
                if (e.dataTransfer.files.length) {
                    imageInput.files = e.dataTransfer.files;
                    handleFiles(e.dataTransfer.files);
                }
            };
            imageInput.onchange = () => handleFiles(imageInput.files);

            function handleFiles(files) {
                [...files].forEach(file => {
                    const div = document.createElement('div');
                    div.className = 'position-relative';
                    div.style.margin = '8px';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'image-preview';
                    div.appendChild(img);

                    const removeBtn = document.createElement('span');
                    removeBtn.className = 'remove-image';
                    removeBtn.innerHTML = '×';
                    removeBtn.onclick = () => div.remove();
                    div.appendChild(removeBtn);

                    previewContainer.appendChild(div);
                });
            }

            currentImages.querySelectorAll('.remove-image').forEach(btn => {
                btn.addEventListener('click', function() {
                    const parent = this.parentElement;
                    const imageId = parent.querySelector('img').dataset.id;

                    const form = parent.closest('form');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'delete_images[]';
                    input.value = imageId;
                    form.appendChild(input);

                    parent.remove();
                });
            });
        });
    </script>
@endsection
