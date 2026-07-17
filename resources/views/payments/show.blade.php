@extends('layouts.app')
@section('title', 'تفاصيل الدفعة')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="bi bi-credit-card me-2"></i>دفعة #{{ $payment->id }}</h1>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-right me-1"></i>رجوع</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><label class="text-muted small">المبلغ</label><p class="fw-bold text-success fs-4">{{ number_format($payment->amount, 2) }} ر.س</p></div>
                <div class="col-md-6"><label class="text-muted small">الحالة</label><p><span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }} fs-6">{{ $payment->status == 'completed' ? 'مكتمل' : 'معلق' }}</span></p></div>
                <div class="col-md-6"><label class="text-muted small">طريقة الدفع</label><p class="fw-bold">{{ $payment->payment_method }}</p></div>
                <div class="col-md-6"><label class="text-muted small">التاريخ</label><p class="fw-bold">{{ $payment->payment_date->format('Y-m-d') }}</p></div>
                <div class="col-md-6"><label class="text-muted small">رقم الفاتورة</label><p class="fw-bold">#{{ $payment->invoice_id }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection
