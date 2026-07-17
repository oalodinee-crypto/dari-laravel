@extends('layouts.app')

@section('title', 'لوحة مالك المبنى')
@section('page-title', 'لوحة التحكم - مالك المبنى')

@section('content')
<div class="container-fluid">
    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">المباني</p>
                        <h3 class="mb-0">{{ $stats['total_buildings'] }}</h3>
                    </div>
                    <div class="icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-city"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">الوحدات</p>
                        <h3 class="mb-0">{{ $stats['total_units'] }}</h3>
                    </div>
                    <div class="icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-door-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">مؤجرة</p>
                        <h3 class="mb-0">{{ $stats['occupied_units'] }}</h3>
                    </div>
                    <div class="icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-key"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">العقود</p>
                        <h3 class="mb-0">{{ $stats['active_contracts'] }}</h3>
                    </div>
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-file-contract"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">صيانة معلقة</p>
                        <h3 class="mb-0 text-danger">{{ $stats['pending_maintenance'] }}</h3>
                    </div>
                    <div class="icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-tools"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">فواتير معلقة</p>
                        <h3 class="mb-0 text-warning">{{ $stats['pending_invoices'] }}</h3>
                    </div>
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-file-invoice"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <a href="{{ route('contracts.create') }}" class="btn btn-primary w-100">
                <i class="bi bi-plus me-2"></i>عقد جديد
            </a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="{{ route('invoices.create') }}" class="btn btn-success w-100">
                <i class="bi bi-file-invoice me-2"></i>فاتورة جديدة
            </a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="{{ route('maintenance.index') }}" class="btn btn-warning w-100">
                <i class="bi bi-tools me-2"></i>طلبات الصيانة
            </a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="{{ route('reports.index') }}" class="btn btn-info w-100">
                <i class="bi bi-chart-bar me-2"></i>التقارير
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Recent Contracts --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-file-contract me-2"></i>آخر العقود</h5>
                    <a href="{{ route('contracts.index') }}" class="btn btn-sm btn-light">عرض الكل</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr><th>العقد</th><th>المستأجر</th><th>الوحدة</th><th>الحالة</th></tr>
                            </thead>
                            <tbody>
                                @forelse($recentContracts as $contract)
                                <tr>
                                    <td>{{ $contract->contract_number }}</td>
                                    <td>{{ $contract->tenant->name ?? '-' }}</td>
                                    <td>{{ $contract->unit->unit_number ?? '-' }}</td>
                                    <td>
                                        @if($contract->status == 'active')
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $contract->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-3">لا توجد عقود</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Maintenance --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-tools me-2"></i>طلبات صيانة معلقة</h5>
                    <a href="{{ route('maintenance.index') }}" class="btn btn-sm btn-light">عرض الكل</a>
                </div>
                <div class="card-body">
                    @forelse($pendingMaintenance as $request)
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <strong>{{ $request->title }}</strong>
                                <br>
                                <small class="text-muted">{{ $request->user->name ?? '' }} - {{ $request->created_at->diffForHumans() }}</small>
                            </div>
                            <a href="{{ route('maintenance.show', $request) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-center text-muted py-3">لا توجد طلبات معلقة</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Announcements --}}
    @if($announcements->count() > 0)
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-bullhorn me-2"></i>الإعلانات</h5>
        </div>
        <div class="card-body">
            @foreach($announcements as $announcement)
                <div class="alert alert-info mb-2">
                    <strong>{{ $announcement->title }}</strong>
                    <p class="mb-0 small">{{ Str::limit($announcement->content, 100) }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
