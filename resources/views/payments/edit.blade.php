@extends('layouts.app')
@section('title', 'تعديل الدفعة')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="bi bi-credit-card me-2"></i>تعديل الدفعة</h1>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-right me-1"></i>رجوع</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('payments.update', $payment) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الفاتورة</label>
                        <select name="invoice_id" class="form-select">
                            @foreach($invoices as $invoice)<option value="{{ $invoice->id }}" {{ $payment->invoice_id == $invoice->id ? 'selected' : '' }}>#{{ $invoice->invoice_number }}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-6"><label class="form-label">المبلغ</label><input type="number" name="amount" class="form-control" value="{{ $payment->amount }}" step="0.01"></div>
                    <div class="col-md-6">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>معلق</option>
                            <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="form-label">التاريخ</label><input type="date" name="payment_date" class="form-control" value="{{ $payment->payment_date->format('Y-m-d') }}"></div>
                </div>
                <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check me-1"></i>حفظ</button>
            </form>
        </div>
    </div>
</div>
@endsection
