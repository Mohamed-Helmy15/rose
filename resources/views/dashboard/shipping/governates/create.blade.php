{{-- resources/views/dashboard/shipping/governates/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة محافظات - زهور')

@section('page-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style>
    .card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .form-control { border-radius: 10px; }
    .form-control:focus { border-color: #4361ee; box-shadow: 0 0 0 0.2rem rgba(67,97,238,0.25); }
    .btn-primary { background: linear-gradient(45deg, #4361ee, #5e7bff); border: none; }
    .btn-primary:hover { background: linear-gradient(45deg, #324bcb, #4361ee); }
    .governate-input { position: relative; margin-bottom: 1rem; }
    .governate-input .btn-remove { position: absolute; left: 8px; top: 50%; transform: translateY(-50%); z-index: 5; }
</style>
@endsection

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
        <span class="text-muted fw-light">الشحن / المحافظات /</span> إضافة محافظات
    </h4>

    <div class="card animate__animated animate__zoomIn">
        <h5 class="card-header">إضافة محافظات جديدة</h5>
        <div class="card-body">
            <form action="{{ route('shipping.governates.store') }}" method="POST">
                @csrf
                <div id="governates-container">
                    <div class="governate-input animate__animated animate__fadeInUp">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label">اسم المحافظة</label>
                                <input type="text" name="governates[0][name]" class="form-control" placeholder="مثال: القاهرة" required>
                                @error('governates.0.name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="governates[0][is_active]" value="1" checked>
                                    <label class="form-check-label">نشط</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger btn-remove d-none" onclick="this.closest('.governate-input').remove()">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-outline-primary mb-3" onclick="addGovernateField()">
                    <i class="bx bx-plus"></i> إضافة محافظة أخرى
                </button>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary animate__animated animate__pulse">حفظ الكل</button>
                    <a href="{{ route('shipping.governates.index') }}" class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let govIndex = 1;
function addGovernateField() {
    const container = document.getElementById('governates-container');
    const div = document.createElement('div');
    div.className = 'governate-input animate__animated animate__fadeInUp';
    div.innerHTML = `
        <div class="row g-3 align-items-end">
            <div class="col-md-8">
                <input type="text" name="governates[${govIndex}][name]" class="form-control" placeholder="اسم المحافظة" required>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="governates[${govIndex}][is_active]" value="1" checked>
                    <label class="form-check-label">نشط</label>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-remove" onclick="this.closest('.governate-input').remove()">
                    <i class="bx bx-x"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(div);
    govIndex++;
}
</script>
@endsection