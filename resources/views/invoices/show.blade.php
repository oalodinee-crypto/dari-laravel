@extends('layouts.app')

@section('title', 'تفاصيل الفاتورة')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-receipt me-2"></i>فاتورة #{{ $invoice->invoice_number }}
        </h1>
        <div>
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>تعديل
            </a>
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-right me-1"></i>رجوع
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>تفاصيل الفاتورة</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small">رقم الفاتورة</label>
                            <p class="fw-bold">{{ $invoice->invoice_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">الحالة</label>
                            <p>
                                @if($invoice->status == 'paid')
                                    <span class="badge bg-success fs-6">مدفوعة</span>
                                @elseif($invoice->status == 'pending')
                                    <span class="badge bg-warning fs-6">معلقة</span>
                                @else
                                    <span class="badge bg-danger fs-6">متأخرة</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">تاريخ الإصدار</label>
                            <p class="fw-bold">{{ $invoice->issue_date->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">تاريخ الاستحقاق</label>
                            <p class="fw-bold">{{ $invoice->due_date->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small">الوصف</label>
                            <p>{{ $invoice->description ?? 'إيجار شهري' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="text-muted small">المبلغ</label>
                            <p class="fw-bold">{{ number_format($invoice->amount, 2) }} ر.س</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">الضريبة</label>
                            <p class="fw-bold">{{ number_format($invoice->tax_amount ?? 0, 2) }} ر.س</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">الإجمالي</label>
                            <p class="fw-bold text-success fs-4">{{ number_format($invoice->total_amount, 2) }} ر.س</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>المستأجر</h5>
                </div>
                <div class="card-body">
                    @if($invoice->tenant)
                        <h6>{{ $invoice->tenant->name }}</h6>
                        <p class="mb-0 text-muted">{{ $invoice->tenant->phone }}</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>المدفوعات</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>المدفوع</span>
                        <span class="text-success">{{ number_format($invoice->paid_amount, 2) }} ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>المتبقي</span>
                        <span class="text-danger">{{ number_format($invoice->remaining_amount, 2) }} ر.س</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
