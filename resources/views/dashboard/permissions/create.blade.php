{{-- resources/views/permissions/create.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'إضافة صلاحيات - زهور')

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

        .permission-input {
            position: relative;
        }

        .permission-input input {
            padding-right: 40px;
        }

        .permission-input .btn-remove {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">الصلاحيات /</span> إضافة صلاحيات
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">إضافة صلاحيات جديدة</h5>
            <div class="card-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div id="permissions-container">
                        <div class="permission-input mb-3 animate__animated animate__fadeInUp">
                            <label class="form-label">اسم الصلاحية</label>
                            <div class="input-group">
                                <input type="text" name="names[]" class="form-control" placeholder="مثال: users.create"
                                    required>
                                <button type="button" class="btn btn-outline-danger btn-remove d-none"
                                    onclick="this.closest('.permission-input').remove()">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            @error('names.0')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary mb-3" onclick="addPermissionField()">
                        <i class="bx bx-plus"></i> إضافة صلاحية أخرى
                    </button>

                    <small class="text-muted d-block mb-3">
                        نصيحة: استخدم صيغة <code>group.action</code> مثل <code>users.create</code>,
                        <code>reports.view</code>
                    </small>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary animate__animated animate__pulse">حفظ الكل</button>
                        <a href="{{ route('permissions.index') }}"
                            class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addPermissionField() {
            const container = document.getElementById('permissions-container');
            const index = container.children.length;
            const div = document.createElement('div');
            div.className = 'permission-input mb-3 animate__animated animate__fadeInUp';
            div.innerHTML = `
        <div class="input-group">
            <input type="text" name="names[]" class="form-control" placeholder="مثال: users.edit" required>
            <button type="button" class="btn btn-outline-danger btn-remove" onclick="this.closest('.permission-input').remove()">
                <i class="bx bx-x"></i>
            </button>
        </div>
        <div class="text-danger mt-1 invalid-feedback"></div>
    `;
            container.appendChild(div);
            setTimeout(() => div.querySelector('input').focus(), 100);
        }
    </script>
@endsection
