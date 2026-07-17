@extends('layouts.app')

@section('title', 'تفاصيل العقد - ' . $contract->contract_number)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-file-earmark-text me-2"></i>عقد رقم {{ $contract->contract_number }}
        </h1>
        <div>
            <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>تعديل
            </a>
            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-right me-1"></i>رجوع
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>معلومات العقد</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small">رقم العقد</label>
                            <p class="fw-bold">{{ $contract->contract_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">الحالة</label>
                            <p>
                                @if($contract->status == 'active')
                                    <span class="badge bg-success">نشط</span>
                                @elseif($contract->status == 'expired')
                                    <span class="badge bg-danger">منتهي</span>
                                @else
                                    <span class="badge bg-secondary">ملغي</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">تاريخ البداية</label>
                            <p class="fw-bold">{{ $contract->start_date->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">تاريخ النهاية</label>
                            <p class="fw-bold">{{ $contract->end_date->format('Y-m-d') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">قيمة العقد</label>
                            <p class="fw-bold text-success fs-5">{{ number_format($contract->amount) }} ر.س</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">دورة الدفع</label>
                            <p class="fw-bold">{{ $contract->payment_frequency }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">التأمين</label>
                            <p class="fw-bold">{{ number_format($contract->security_deposit ?? 0) }} ر.س</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">الأيام المتبقية</label>
                            <p class="fw-bold {{ $contract->days_remaining > 30 ? 'text-success' : 'text-danger' }}">
                                {{ $contract->days_remaining > 0 ? $contract->days_remaining . ' يوم' : 'منتهي' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الشروط -->
            @if($contract->terms)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>شروط العقد</h5>
                </div>
                <div class="card-body">
                    <p>{{ $contract->terms }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- الوحدة -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-door-open me-2"></i>الوحدة</h5>
                </div>
                <div class="card-body">
                    @if($contract->unit)
                        <h6>{{ $contract->unit->building->name ?? '' }}</h6>
                        <p class="mb-1">وحدة: {{ $contract->unit->unit_number }}</p>
                        <p class="mb-0 text-muted">الطابق: {{ $contract->unit->floor_number }}</p>
                        <a href="{{ route('units.show', $contract->unit) }}" class="btn btn-sm btn-outline-primary mt-2">
                            عرض الوحدة
                        </a>
                    @else
                        <p class="text-muted">غير محدد</p>
                    @endif
                </div>
            </div>

            <!-- المستأجر -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>المستأجر</h5>
                </div>
                <div class="card-body">
                    @if($contract->tenant)
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                {{ mb_substr($contract->tenant->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $contract->tenant->name }}</h6>
                                <small class="text-muted">{{ $contract->tenant->phone }}</small>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">غير محدد</p>
                    @endif
                </div>
            </div>

            <!-- الفواتير -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>الفواتير</h5>
                </div>
                <div class="card-body">
                    @if($contract->invoices->count() > 0)
                        @foreach($contract->invoices->take(5) as $invoice)
                            <div class="d-flex justify-content-between mb-2">
                                <span>#{{ $invoice->id }}</span>
                                <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : 'warning' }}">
                                    {{ number_format($invoice->total_amount) }} ر.س
                                </span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">لا توجد فواتير</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
