{{-- resources/views/dashboard/supplier_evaluations/show.blade.php --}}
@extends('layouts/contentNavbarLayout')

@section('title', 'تفاصيل تقييم المورد - زهور')

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

        .eval-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4361ee, #5e7bff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            font-weight: bold;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
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
            <span class="text-muted fw-light">تقييمات الموردين /</span> #{{ $supplierEvaluation->id }}
        </h4>

        <div class="card animate__animated animate__zoomIn">
            <h5 class="card-header">#{{ $supplierEvaluation->id }} - {{ $supplierEvaluation->supplier->name }}</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 text-center mb-4">
                        <div class="eval-avatar-large">
                            EV
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                                <div class="section-content">
                                    <h6 class="section-title">تاريخ التقييم</h6>
                                    <p>{{ $supplierEvaluation->evaluation_date->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInRight">
                                <div class="section-content">
                                    <h6 class="section-title">التقييم</h6>
                                    <p>{{ number_format($supplierEvaluation->rating, 1) }} / 5</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 animate__animated animate__fadeInLeft">
                                <div class="section-content">
                                    <h6 class="section-title">المقيم</h6>
                                    <p>{{ $supplierEvaluation->evaluatedBy->name }}</p>
                                </div>
                            </div>
                            <div class="col-12 mb-3 animate__animated animate__fadeInUp">
                                <div class="section-content">
                                    <h6 class="section-title">التعليقات</h6>
                                    <p>{{ $supplierEvaluation->comments ?? 'لا توجد تعليقات' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons mt-4">
                    <a href="{{ route('supplier-evaluations.index') }}"
                        class="btn btn-secondary animate__animated animate__pulse">عودة</a>
                    <a href="{{ route('supplier-evaluations.edit', $supplierEvaluation) }}"
                        class="btn btn-primary animate__animated animate__pulse">تعديل</a>
                </div>
            </div>
        </div>
    </div>
@endsection
