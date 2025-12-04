@extends('layouts/contentNavbarLayout')

@section('title', 'المستخدمين - زهور')

@section('page-style')
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
        .section-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            transition: background 0.3s ease;
        }
        .section-content:hover {
            background: #e9ecef;
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
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid animate__animated animate__fadeIn">
        <h4 class="py-3 mb-4 animate__animated animate__fadeInDown">
            <span class="text-muted fw-light">المستخدمين /</span> {{ $user->name }}
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">{{ $user->name }}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                        <div class="section-content">
                            <h6 class="section-title">الاسم</h6>
                            <p>{{ $user->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                        <div class="section-content">
                            <h6 class="section-title">البريد الإلكتروني</h6>
                            <p>{{ $user->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                        <div class="section-content">
                            <h6 class="section-title">الهاتف</h6>
                            <p>{{ $user->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                        <div class="section-content">
                            <h6 class="section-title">الدور</h6>
                            <p>{{ $user->role ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                        <div class="section-content">
                            <h6 class="section-title">نشط</h6>
                            <p>{{ $user->is_active ? 'نعم' : 'لا' }}</p>
                        </div>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary animate__animated animate__pulse">عودة</a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary animate__animated animate__pulse">تعديل</a>
                </div>
            </div>
        </div>
    </div>
@endsection