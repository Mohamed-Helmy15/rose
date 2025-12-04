@extends('layouts/contentNavbarLayout')

@section('title', 'المستخدمين - زهور')

@section('content')
    <div class="container-fluid">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">المستخدمين /</span> {{ $user->name }}
        </h4>

        <div class="card">
            <h5 class="card-header">{{ $user->name }}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">الاسم</h6>
                            <p>{{ $user->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">البريد الإلكتروني</h6>
                            <p>{{ $user->email ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">الهاتف</h6>
                            <p>{{ $user->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">الدور</h6>
                            <p>{{ $user->role ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">الفرع</h6>
                            <p>{{ $user->branch ? $user->branch->name : 'غير محدد' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">نشط</h6>
                            <p>{{ $user->is_active ? 'نعم' : 'لا' }}</p>
                        </div>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">عودة</a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">تعديل</a>
                </div>
            </div>
        </div>
    </div>
@endsection