@extends('layouts.app')

@section('title', 'تعديل عقد')

@section('content')
<div class="card p-4">
    <h5 class="mb-4"><i class="bi bi-file-earmark-text me-2"></i> تعديل عقد: {{ $contract->contract_number }}</h5>
    
    <form action="{{ route('contracts.update', $contract) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">الساكن</label>
                <select name="tenant_id" class="form-select" required>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ $contract->tenant_id == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">الوحدة</label>
                <select name="unit_id" class="form-select" required>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ $contract->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->building->name ?? '' }} - {{ $unit->unit_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">نوع العقد</label>
                <select name="type" class="form-select" required>
                    <option value="rent" {{ $contract->type == 'rent' ? 'selected' : '' }}>إيجار</option>
                    <option value="sale" {{ $contract->type == 'sale' ? 'selected' : '' }}>بيع</option>
                    <option value="lease" {{ $contract->type == 'lease' ? 'selected' : '' }}>تأجير طويل المدى</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">دورية الدفع</label>
                <select name="payment_frequency" class="form-select" required>
                    <option value="monthly" {{ $contract->payment_frequency == 'monthly' ? 'selected' : '' }}>شهري</option>
                    <option value="quarterly" {{ $contract->payment_frequency == 'quarterly' ? 'selected' : '' }}>ربع سنوي</option>
                    <option value="semi_annual" {{ $contract->payment_frequency == 'semi_annual' ? 'selected' : '' }}>نصف سنوي</option>
                    <option value="annual" {{ $contract->payment_frequency == 'annual' ? 'selected' : '' }}>سنوي</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">تاريخ البداية</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $contract->start_date?->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">تاريخ النهاية</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $contract->end_date?->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">الإيجار الشهري</label>
                <input type="number" name="amount" class="form-control" value="{{ old('amount', $contract->amount) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ $contract->status == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="expired" {{ $contract->status == 'expired' ? 'selected' : '' }}>منتهي</option>
                    <option value="terminated" {{ $contract->status == 'terminated' ? 'selected' : '' }}>ملغي</option>
                </select>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                <a href="{{ route('contracts.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection