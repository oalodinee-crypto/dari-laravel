@extends('layouts.app')

@section('title', 'تسجيل دفعة')
@section('page-title', 'تسجيل دفعة جديدة')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-plus-circle text-primary me-2"></i>
                    تسجيل دفعة جديدة
                </h2>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-1"></i>
                    العودة
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الفاتورة <span class="text-danger">*</span></label>
                                <select class="form-select @error('invoice_id') is-invalid @enderror" name="invoice_id" required>
                                    <option value="">-- اختر الفاتورة --</option>
                                    @foreach($invoices as $invoice)
                                        <option value="{{ $invoice->id }}" {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>
                                            {{ $invoice->invoice_number }} - {{ $invoice->contract->tenant->name ?? 'غير محدد' }} ({{ number_format($invoice->amount, 2) }} ر.س)
                                        </option>
                                    @endforeach
                                </select>
                                @error('invoice_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">المبلغ <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                           name="amount" value="{{ old('amount') }}" step="0.01" min="0" required>
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">طريقة الدفع <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method" required>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدي</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                                    <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>شيك</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>بطاقة</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ الدفع <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                                       name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">رقم المرجع</label>
                            <input type="text" class="form-control" name="reference_number" 
                                   value="{{ old('reference_number', 'PAY-' . date('YmdHis')) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ملاحظات</label>
                            <textarea class="form-control" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                تسجيل الدفعة
                            </button>
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>معلومات</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        سيتم تحديث حالة الفاتورة تلقائياً
                    </p>
                    <p class="small mb-2">
                        <i class="bi bi-check text-success me-2"></i>
                        يمكن تسجيل دفعات جزئية
                    </p>
                    <p class="small mb-0">
                        <i class="bi bi-check text-success me-2"></i>
                        سيتم إرسال إيصال للمستأجر
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
