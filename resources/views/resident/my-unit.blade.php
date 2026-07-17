@extends('layouts.app')

@section('title', 'وحدتي')

@section('content')
<div class="mb-4">
    <h4 class="mb-0">
        <i class="bi bi-house-door me-2"></i>
        معلومات الوحدة
    </h4>
</div>

@if($contract)
    <div class="row">
        {{-- Unit Info --}}
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-house me-2"></i>معلومات الوحدة</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" width="40%">المبنى</td>
                            <td><strong>{{ $contract->unit->building->name ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">رقم الوحدة</td>
                            <td><strong>{{ $contract->unit->unit_number ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">الطابق</td>
                            <td>{{ $contract->unit->floor_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">النوع</td>
                            <td>{{ $contract->unit->type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">المساحة</td>
                            <td>{{ $contract->unit->area ?? '-' }} م²</td>
                        </tr>
                        <tr>
                            <td class="text-muted">غرف النوم</td>
                            <td>{{ $contract->unit->bedrooms ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">دورات المياه</td>
                            <td>{{ $contract->unit->bathrooms ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Contract Info --}}
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>معلومات العقد</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" width="40%">رقم العقد</td>
                            <td><strong>{{ $contract->contract_number ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">تاريخ البداية</td>
                            <td>{{ $contract->start_date ? $contract->start_date->format('Y-m-d') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">تاريخ النهاية</td>
                            <td>{{ $contract->end_date ? $contract->end_date->format('Y-m-d') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">الإيجار الشهري</td>
                            <td class="text-success fw-bold">{{ number_format($contract->amount ?? 0, 2) }} ر.س</td>
                        </tr>
                        <tr>
                            <td class="text-muted">مبلغ التأمين</td>
                            <td>{{ number_format($contract->security_deposit ?? 0, 2) }} ر.س</td>
                        </tr>
                        <tr>
                            <td class="text-muted">حالة العقد</td>
                            <td>
                                @if($contract->status == 'active')
                                    <span class="badge bg-success">نشط</span>
                                @elseif($contract->status == 'expired')
                                    <span class="badge bg-danger">منتهي</span>
                                @else
                                    <span class="badge bg-secondary">{{ $contract->status }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">المتبقي</td>
                            <td>
                                @if($contract->end_date)
                                    @php
                                        $remaining = now()->diffInDays($contract->end_date, false);
                                    @endphp
                                    @if($remaining > 30)
                                        <span class="text-success">{{ $remaining }} يوم</span>
                                    @elseif($remaining > 0)
                                        <span class="text-warning">{{ $remaining }} يوم</span>
                                    @else
                                        <span class="text-danger">منتهي</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Building Address --}}
    @if($contract->unit && $contract->unit->building)
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>العنوان</h5>
        </div>
        <div class="card-body">
            <p class="mb-0">
                <i class="bi bi-building me-2 text-primary"></i>
                {{ $contract->unit->building->name ?? '' }} - 
                {{ $contract->unit->building->address ?? '' }}{{ $contract->unit->building->city ? ', ' . $contract->unit->building->city : '' }}
            </p>
        </div>
    </div>
    @endif
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-house text-muted" style="font-size: 4rem;"></i>
            <h4 class="text-muted mt-3">لا يوجد عقد إيجار نشط</h4>
            <p class="text-muted">لم يتم العثور على عقد إيجار نشط مرتبط بحسابك</p>
        </div>
    </div>
@endif
@endsection
