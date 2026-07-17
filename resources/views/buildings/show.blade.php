@extends('layouts.app')

@section('title', 'تفاصيل المبنى - ' . $building->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>{{ $building->name }}
        </h1>
        <div>
            <a href="{{ route('buildings.edit', $building) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>تعديل
            </a>
            <a href="{{ route('buildings.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-right me-1"></i>رجوع
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>معلومات المبنى</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small">اسم المبنى</label>
                            <p class="fw-bold">{{ $building->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">العنوان</label>
                            <p class="fw-bold">{{ $building->address }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">عدد الطوابق</label>
                            <p class="fw-bold">{{ $building->floors_count }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">عدد الوحدات</label>
                            <p class="fw-bold">{{ $building->units_count }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">سنة البناء</label>
                            <p class="fw-bold">{{ $building->year_built ?? '-' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small">الوصف</label>
                            <p>{{ $building->description ?? 'لا يوجد وصف' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الوحدات -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-door-open me-2"></i>الوحدات</h5>
                    <a href="{{ route('units.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus me-1"></i>إضافة وحدة
                    </a>
                </div>
                <div class="card-body">
                    @if($building->units->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الوحدة</th>
                                        <th>الطابق</th>
                                        <th>النوع</th>
                                        <th>الحالة</th>
                                        <th>الإيجار</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($building->units as $unit)
                                    <tr>
                                        <td><a href="{{ route('units.show', $unit) }}">{{ $unit->unit_number }}</a></td>
                                        <td>{{ $unit->floor_number }}</td>
                                        <td>{{ $unit->type }}</td>
                                        <td>
                                            @if($unit->status == 'available')
                                                <span class="badge bg-success">متاحة</span>
                                            @elseif($unit->status == 'occupied')
                                                <span class="badge bg-primary">مؤجرة</span>
                                            @else
                                                <span class="badge bg-warning">صيانة</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($unit->rent_amount) }} ر.س</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4">لا توجد وحدات</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- إحصائيات -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>إحصائيات</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>إجمالي الوحدات</span>
                        <span class="badge bg-primary fs-6">{{ $building->units->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>الوحدات المؤجرة</span>
                        <span class="badge bg-success fs-6">{{ $building->units->where('status', 'occupied')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>الوحدات المتاحة</span>
                        <span class="badge bg-info fs-6">{{ $building->units->where('status', 'available')->count() }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>نسبة الإشغال</span>
                        @php
                            $occupancy = $building->units->count() > 0 
                                ? round(($building->units->where('status', 'occupied')->count() / $building->units->count()) * 100) 
                                : 0;
                        @endphp
                        <span class="fw-bold text-{{ $occupancy >= 70 ? 'success' : ($occupancy >= 40 ? 'warning' : 'danger') }}">{{ $occupancy }}%</span>
                    </div>
                </div>
            </div>

            <!-- المدير -->
            @if($building->manager)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>مدير المبنى</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            {{ mb_substr($building->manager->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $building->manager->name }}</h6>
                            <small class="text-muted">{{ $building->manager->phone }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
