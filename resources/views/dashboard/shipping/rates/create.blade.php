{{-- resources/views/dashboard/shipping/rates/create.blade.php --}}
@extends('layouts.contentNavbarLayout')

@section('title', 'إضافة أسعار شحن - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .form-control, .form-select { border-radius: 10px; }
    .form-control:focus { border-color: #4361ee; box-shadow: 0 0 0 0.2rem rgba(67,97,238,0.25); }
    .btn-primary { background: linear-gradient(45deg, #4361ee, #5e7bff); border: none; }
    .btn-primary:hover { background: linear-gradient(45deg, #324bcb, #4361ee); }
    .rate-input { position: relative; margin-bottom: 1rem; }
    .rate-input .btn-remove { position: absolute; left: 8px; top: 50%; transform: translateY(-50%); z-index: 5; }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">الشحن / أسعار الشحن /</span> إضافة أسعار
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">إضافة أسعار شحن جديدة</h5>
        <div class="card-body">
            <form action="{{ route('shipping.rates.store') }}" method="POST">
                @csrf
                <div id="rates-container">
                    <div class="rate-input animate__animated animate__fadeInUp">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">المكان</label>
                                <select name="rates[0][location_id]" class="form-select" required>
                                    <option value="">اختر مكانًا</option>
                                    @foreach($locations as $loc)
                                        <option value="{{ $loc->id }}">
                                            {{ $loc->name }} ({{ $loc->city->name }}, {{ $loc->city->governate->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('rates.0.location_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">السعر (جنيه)</label>
                                <input type="number" name="rates[0][rate]" class="form-control" step="0.01" required>
                                @error('rates.0.rate')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="rates[0][is_active]" value="1" checked>
                                    <label class="form-check-label">نشط</label>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger btn-remove d-none" onclick="this.closest('.rate-input').remove()">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary mb-3" onclick="addRateField()">
                    <i class="bx bx-plus"></i> إضافة سعر آخر
                </button>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary animate__animated animate__pulse">حفظ الكل</button>
                    <a href="{{ route('shipping.rates.index') }}" class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let rateIndex = 1;
function addRateField() {
    const container = document.getElementById('rates-container');
    const div = document.createElement('div');
    div.className = 'rate-input animate__animated animate__fadeInUp';
    div.innerHTML = `
        <div class="row g-3">
            <div class="col-md-6">
                <select name="rates[${rateIndex}][location_id]" class="form-select" required>
                    <option value="">اختر مكانًا</option>
                    @foreach($locations as $loc)
                        <option value="{{ $loc->id }}">
                            {{ $loc->name }} ({{ $loc->city->name }}, {{ $loc->city->governate->name }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="rates[${rateIndex}][rate]" class="form-control" step="0.01" placeholder="السعر" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="rates[${rateIndex}][is_active]" value="1" checked>
                    <label class="form-check-label">نشط</label>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger btn-remove" onclick="this.closest('.rate-input').remove()">
                    <i class="bx bx-x"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(div);
    rateIndex++;
}
</script>
@endsection