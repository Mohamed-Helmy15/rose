{{-- resources/views/dashboard/goods_received_notes/edit.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تعديل إيصال استلام - ممنوع')

@section('content')
<div class="container-fluid py-5 text-center">
    <div class="card border-danger">
        <div class="card-body">
            <i class='bx bx-lock fs-1 text-danger'></i>
            <h3 class="mt-3 text-danger">تعديل إيصال الاستلام ممنوع</h3>
            <p class="text-muted">بعد تأكيد الاستلام، لا يمكن تعديل الإيصال لحماية سلامة المخزون وتتبع الباتشات.</p>
            <a href="{{ route('goods-received-notes.index') }}" class="btn btn-primary mt-3">عودة إلى القائمة</a>
        </div>
    </div>
</div>
@endsection