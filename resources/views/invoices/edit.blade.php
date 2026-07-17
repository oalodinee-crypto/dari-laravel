@extends('layouts.app')

@section('title', 'تعديل الفاتورة')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="bi bi-receipt me-2"></i>تعديل الفاتورة #{{ $invoice->invoice_number }}</h1>
        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right me-1"></i>رجوع
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الوحدة</label>
                        <select name="unit_id" class="form-select" required>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ $invoice->unit_id == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->building->name ?? '' }} - {{ $unit->unit_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الحالة</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $invoice->status == 'pending' ? 'selected' : '' }}>معلقة</option>
                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>مدفوعة</option>
                            <option value="overdue" {{ $invoice->status == 'overdue' ? 'selected' : '' }}>متأخرة</option>
                            <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">نوع الفاتورة</label>
                        <select name="type" class="form-select" required>
                            <option value="rent" {{ $invoice->type == 'rent' ? 'selected' : '' }}>إيجار</option>
                            <option value="maintenance" {{ $invoice->type == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                            <option value="utilities" {{ $invoice->type == 'utilities' ? 'selected' : '' }}>خدمات</option>
                            <option value="water" {{ $invoice->type == 'water' ? 'selected' : '' }}>فاتورة مياه</option>
                            <option value="electricity" {{ $invoice->type == 'electricity' ? 'selected' : '' }}>فاتورة كهرباء</option>
                            <option value="other" {{ $invoice->type == 'other' ? 'selected' : '' }}>أخرى</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">المبلغ</label>
                        <input type="number" name="amount" class="form-control" step="0.01" value="{{ $invoice->amount }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تاريخ الاستحقاق</label>
                        <input type="date" name="due_date" class="form-control" value="{{ $invoice->due_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control" rows="2">{{ $invoice->description }}</textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check me-1"></i>حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
