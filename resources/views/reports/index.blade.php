@extends('layouts.app')

@section('title', 'التقارير')
@section('page-title', 'التقارير والتصدير')

@section('content')
<div class="row g-4">
    <!-- Buildings Report -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="bi bi-building fs-2 text-primary"></i>
                </div>
                <h5>تقرير المباني</h5>
                <p class="text-muted small">تصدير بيانات جميع المباني والوحدات</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('export.buildings', ['format' => 'csv']) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-filetype-csv me-1"></i>CSV
                    </a>
                    <a href="{{ route('export.buildings', ['format' => 'pdf']) }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Units Report -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="rounded-circle bg-success bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="bi bi-door-open fs-2 text-success"></i>
                </div>
                <h5>تقرير الوحدات</h5>
                <p class="text-muted small">تفاصيل جميع الوحدات السكنية</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('export.units', ['format' => 'csv']) }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-filetype-csv me-1"></i>CSV
                    </a>
                    <a href="{{ route('export.units', ['format' => 'pdf']) }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contracts Report -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="bi bi-file-text fs-2 text-info"></i>
                </div>
                <h5>تقرير العقود</h5>
                <p class="text-muted small">جميع العقود النشطة والمنتهية</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('export.contracts', ['format' => 'csv']) }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-filetype-csv me-1"></i>CSV
                    </a>
                    <a href="{{ route('export.contracts', ['format' => 'pdf']) }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Report -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="bi bi-receipt fs-2 text-warning"></i>
                </div>
                <h5>تقرير الفواتير</h5>
                <p class="text-muted small">جميع الفواتير الصادرة</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('export.invoices', ['format' => 'csv']) }}" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-filetype-csv me-1"></i>CSV
                    </a>
                    <a href="{{ route('export.invoices', ['format' => 'pdf']) }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Report -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="bi bi-wallet2 fs-2 text-danger"></i>
                </div>
                <h5>تقرير المدفوعات</h5>
                <p class="text-muted small">سجل جميع عمليات الدفع</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('export.payments', ['format' => 'csv']) }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-filetype-csv me-1"></i>CSV
                    </a>
                    <a href="{{ route('export.payments', ['format' => 'pdf']) }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="rounded-circle bg-dark bg-opacity-10 p-3 d-inline-flex mb-3">
                    <i class="bi bi-graph-up fs-2 text-dark"></i>
                </div>
                <h5>الملخص المالي</h5>
                <p class="text-muted small">ملخص شامل للوضع المالي</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('export.financial', ['format' => 'csv']) }}" class="btn btn-outline-dark btn-sm">
                        <i class="bi bi-filetype-csv me-1"></i>CSV
                    </a>
                    <a href="{{ route('export.financial', ['format' => 'pdf']) }}" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
