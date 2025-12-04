@extends('layouts/contentNavbarLayout')

@section('title', 'إنشاء مستخدم - زهور')

@section('page-style')
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
    <style>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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

        .form-control {
            border-radius: 10px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
            transition: background 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(45deg, #5a6268, #868e96);
        }

        .text-danger {
            font-size: 0.875rem;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">المستخدمين /</span> إنشاء مستخدم
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">إنشاء مستخدم</h5>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <label class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <label class="form-label">الهاتف</label>
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <label class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                            <label class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <label class="form-label">الدور</label>
                            <select class="form-select" name="role">
                                <option value="">اختر دورًا</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (settings('multi_branch'))
                            <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                                <label class="form-label">الفروع المسموح للمستخدم العمل بها</label>
                                <select name="branch_ids[]" multiple class="form-select" id="branch-choices">
                                    @foreach (\App\Models\Branch::active()->get() as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }} ({{ $branch->code }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">اختر فرع أو أكثر (Ctrl + Click)</small>
                            </div>
                        @endif



                        <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                    value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">نشط</label>
                            </div>
                            @error('is_active')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary animate__animated animate__pulse">حفظ</button>
                        <a href="{{ route('users.index') }}"
                            class="btn btn-secondary animate__animated animate__pulse">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new Choices('#branch-choices', {
            removeItemButton: true,
            placeholderValue: 'اختر الفروع...',
            noResultsText: 'لا توجد فروع',
        });
    });
</script>
