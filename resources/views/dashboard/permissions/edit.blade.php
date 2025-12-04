{{-- resources/views/permissions/edit.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تعديل صلاحية - زهور')

@section('page-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-control {
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
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">الصلاحيات /</span> تعديل صلاحية
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">تعديل الصلاحية</h5>
            <div class="card-body">
                <form action="{{ route('permissions.update', $permission) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">اسم الصلاحية</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $permission->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <small class="text-muted d-block mb-3">
                        صيغة مقترحة: <code>group.action</code>
                    </small>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary animate__animated animate__pulse">تحديث</button>
                        <a href="{{ route('permissions.index') }}"
                            class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
