@extends('layouts.app')

@section('title', 'إنشاء عقد جديد')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-plus-circle text-primary me-2"></i>
                    إنشاء عقد جديد
                </h2>
                <a href="{{ route('contracts.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-1"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-file-contract me-2"></i>
                        بيانات العقد
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('contracts.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contract_number" class="form-label">رقم العقد <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('contract_number') is-invalid @enderror" 
                                       id="contract_number" name="contract_number" value="{{ old('contract_number', 'CNT-' . date('Ymd') . '-' . rand(100,999)) }}" required>
                                @error('contract_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tenant_id" class="form-label">المستأجر <span class="text-danger">*</span></label>
                                <select class="form-select @error('tenant_id') is-invalid @enderror" id="tenant_id" name="tenant_id" required>
                                    <option value="">-- اختر المستأجر --</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                            {{ $tenant->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tenant_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="unit_id" class="form-label">الوحدة <span class="text-danger">*</span></label>
                                <select class="form-select @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id" required>
                                    <option value="">-- اختر الوحدة --</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->unit_number }} - {{ $unit->building->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">الإيجار الشهري <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required>
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">تاريخ البداية <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">تاريخ النهاية <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="deposit_amount" class="form-label">مبلغ التأمين</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('deposit_amount') is-invalid @enderror" 
                                           id="deposit_amount" name="deposit_amount" value="{{ old('deposit_amount') }}" step="0.01" min="0">
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('deposit_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">حالة العقد</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="terms" class="form-label">شروط العقد</label>
                            <textarea class="form-control @error('terms') is-invalid @enderror" 
                                      id="terms" name="terms" rows="4">{{ old('terms') }}</textarea>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                حفظ العقد
                            </button>
                            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">
                                <i class="bi bi-times me-1"></i>
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        ملاحظات
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            تأكد من صحة بيانات المستأجر
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            حدد تاريخ البداية والنهاية بدقة
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            مبلغ التأمين اختياري
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-2"></i>
                            يمكن إضافة شروط العقد لاحقاً
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
