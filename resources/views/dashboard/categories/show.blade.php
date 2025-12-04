@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل التصنيف - زهور')

@section('content')
<div class="container-fluid">
    <h4 class="py-3 mb-4"><span class="text-muted">التصنيفات /</span> {{ $category->name }}</h4>

    <div class="card">
        <div class="card-body">
            @if($category->image)
                <img src="{{ asset('storage/'.$category->image) }}" class="rounded mb-4" style="max-height: 300px;">
            @endif
            <h3>{{ $category->name }} <small class="text-muted">({{ $category->code }})</small></h3>
            <p><strong>اللون:</strong> <span style="padding: 10px 20px; background: {{ $category->color }}; color: white; border-radius: 10px;">{{ $category->color }}</span></p>
            <p><strong>الوصف:</strong> {{ $category->description ?? 'لا يوجد' }}</p>
            <p><strong>الأب:</strong> {{ $category->parent?->name ?? 'لا يوجد' }}</p>
            <p><strong>الحالة:</strong> {{ $category->is_active ? 'نشط' : 'معطل' }}</p>

            <a href="{{ route('categories.index') }}" class="btn btn-secondary">عودة</a>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">تعديل</a>
        </div>
    </div>
</div>
@endsection