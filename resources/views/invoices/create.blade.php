@extends('layouts.app')

@section('title', 'إنشاء فاتورة جديدة')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="bi bi-receipt me-2"></i>إنشاء فاتورة جديدة</h1>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right me-1"></i>رجوع
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">الوحدة</label>
                        <select name="unit_id" class="form-select" required>
                            <option value="">اختر الوحدة</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->building->name ?? '' }} - {{ $unit->unit_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">العقد (اختياري)</label>
                        <select name="contract_id" class="form-select">
                            <option value="">اختر العقد</option>
                            @foreach($contracts as $contract)
                                <option value="{{ $contract->id }}">#{{ $contract->contract_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">نوع الفاتورة</label>
                        <select name="type" class="form-select" required>
                            <option value="rent">إيجار</option>
                            <option value="maintenance">صيانة</option>
                            <option value="utilities">خدمات</option>
                            <option value="water">فاتورة مياه</option>
                            <option value="electricity">فاتورة كهرباء</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">المبلغ</label>
                        <input type="number" name="amount" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تاريخ الإصدار</label>
                        <input type="date" name="issue_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تاريخ الاستحقاق</label>
                        <input type="date" name="due_date" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check me-1"></i>إنشاء الفاتورة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
