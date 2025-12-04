{{-- resources/views/dashboard/products/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة منتج جديد - زهور')

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

        .drop-zone {
            border: 3px dashed #4361ee;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            background: #f8f9ff;
            cursor: pointer;
            transition: all 0.3s;
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

        .color-preview {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            border: 5px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
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
            <span class="text-muted fw-light">المنتجات /</span> إضافة منتج جديد
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header bg-primary text-white py-4">إضافة منتج جديد</h5>
            <div class="card-body p-5">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- رفع الصور -->
                    <div class="text-center mb-5">
                        <div class="drop-zone" id="dropZone">
                            <i class='bx bxs-cloud-upload' style="font-size: 4rem; color: #4361ee;"></i>
                            <p class="mt-3 fw-bold">اسحب الصور هنا أو اضغط للرفع (متعدد)</p>
                            <small class="text-muted">PNG, JPG, WEBP • حتى 5MB</small>
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*" hidden>
                        </div>
                        <div id="imagePreviewContainer" class="d-flex flex-wrap justify-content-center mt-4"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">سعر البيع <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control form-control-lg" name="price"
                                value="{{ old('price') }}" required>
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">سعر التكلفة</label>
                            <input type="number" step="0.01" class="form-control" name="cost_price"
                                value="{{ old('cost_price') }}">
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">الكمية المتاحة <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="stock_quantity"
                                value="{{ old('stock_quantity', 0) }}" required>
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInLeft">
                            <label class="form-label">حد إعادة الطلب</label>
                            <input type="number" class="form-control" name="reorder_level"
                                value="{{ old('reorder_level', settings('reorder_level_alert', 10)) }}">
                        </div>

                        <div class="col-md-6 animate__animated animate__fadeInRight">
                            <label class="form-label">اللون المميز</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="color" class="form-control form-control-color" name="color"
                                    value="{{ old('color', '#4361ee') }}" style="width:100px;height:60px;">
                                <div class="color-preview" id="colorPreview"
                                    style="background-color: {{ old('color', '#4361ee') }};"></div>
                            </div>
                        </div>

                        <div class="col-12 animate__animated animate__fadeInUp">
                            <label class="form-label">التصنيفات <span class="text-danger">*</span></label>
                            <select name="category_ids[]" multiple class="form-select" id="category-choices">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->full_name ?? $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if (settings('multi_branch'))
                            <div class="col-md-6 animate__animated animate__fadeInLeft">
                                <label class="form-label">الفرع</label>
                                <select name="branch_id" class="form-select" required>
                                    <option value="">-- اختر الفرع --</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="col-12 animate__animated animate__fadeInUp">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" rows="4" name="description">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                <label class="form-check-label">المنتج نشط</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 d-flex gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5 animate__animated animate__pulse">
                            <i class='bx bx-check'></i> حفظ المنتج
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
                placeholderValue: 'اختر التصنيفات...',
                noResultsText: 'لا توجد تصنيفات',
            });

            const dropZone = document.getElementById('dropZone');
            const imageInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const colorInput = document.querySelector('input[name="color"]');
            const colorPreview = document.getElementById('colorPreview');

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
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'image-preview';
                        previewsectors.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }

            colorInput.oninput = () => colorPreview.style.backgroundColor = colorInput.value;
        });
    </script>
@endsection
