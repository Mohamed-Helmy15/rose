@extends('layouts/contentNavbarLayout')

@section('title', 'نقطة البيع POS - زهور')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">نقطة البيع - فرع {{ auth()->user()->primaryBranch()?->name ?? 'الرئيسي' }}</h3>

    <livewire:pos />
</div>
@endsection