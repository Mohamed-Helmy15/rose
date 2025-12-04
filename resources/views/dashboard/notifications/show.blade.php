@extends('layouts/contentNavbarLayout')

@section('title', 'الإشعارات - زهور')

@section('content')
    <div class="container-fluid">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">الإشعارات /</span> {{ $notification->action }}
        </h4>

        <div class="card">
            <h5 class="card-header">{{ $notification->action }}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">المنفذ</h6>
                            <p>{{ $notification->actor ? $notification->actor->name : 'غير محدد' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">الإجراء</h6>
                            <p>{{ $notification->action ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">الوصف</h6>
                            <p>{{ $notification->description ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="section-content">
                            <h6 class="section-title">التاريخ</h6>
                            <p>{{ $notification->created_at ? $notification->created_at->format('Y-m-d H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="action-buttons">
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary">عودة</a>
                    {{-- <a href="{{ route('notifications.edit', $notification) }}" class="btn btn-primary">تعديل</a> --}}
                </div>
            </div>
        </div>
    </div>
@endsection