{{-- resources/views/dashboard/shipping/cities/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة مدن - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .btn-primary {
            background: linear-gradient(45deg, #4361ee, #5e7bff);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #324bcb, #4361ee);
        }

        .city-input {
            position: relative;
            margin-bottom: 1rem;
        }

        .city-input .btn-remove {
            position: absolute;
            right: 20px;
            top: 64%;
            transform: translateY(-50%);
            z-index: 5;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">الشحن / المدن /</span> إضافة مدن
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">إضافة مدن جديدة</h5>
            <div class="card-body">
                <form action="{{ route('shipping.cities.store') }}" method="POST">
                    @csrf
                    <div id="cities-container">
                        <div class="city-input animate__animated animate__fadeInUp">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="form-label">اسم المدينة</label>
                                    <input type="text" name="cities[0][name]" class="form-control" required>
                                    @error('cities.0.name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">المحافظة</label>
                                    <select name="cities[0][governate_id]" class="form-select" required>
                                        <option value="">اختر محافظة</option>
                                        @foreach ($governates as $g)
                                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cities.0.governate_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cities[0][is_active]"
                                            value="1" checked>
                                        <label class="form-check-label">نشط</label>
                                    </div>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger btn-remove d-none"
                                        onclick="this.closest('.city-input').remove()">
                                        <i class="bx bx-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary mb-3" onclick="addCityField()">
                        <i class="bx bx-plus"></i> إضافة مدينة أخرى
                    </button>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary animate__animated animate__pulse">حفظ الكل</button>
                        <a href="{{ route('shipping.cities.index') }}"
                            class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let cityIndex = 1;

        function addCityField() {
            const container = document.getElementById('cities-container');
            const div = document.createElement('div');
            div.className = 'city-input animate__animated animate__fadeInUp';
            div.innerHTML = `
        <div class="row g-3">
            <div class="col-md-5">
                <input type="text" name="cities[${cityIndex}][name]" class="form-control" placeholder="اسم المدينة" required>
            </div>
            <div class="col-md-5">
                <select name="cities[${cityIndex}][governate_id]" class="form-select" required>
                    <option value="">اختر محافظة</option>
                    @foreach ($governates as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="cities[${cityIndex}][is_active]" value="1" checked>
                    <label class="form-check-label">نشط</label>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger btn-remove" onclick="this.closest('.city-input').remove()">
                    <i class="bx bx-x"></i>
                </button>
            </div>
        </div>
    `;
            container.appendChild(div);
            cityIndex++;
        }
    </script>
@endsection
