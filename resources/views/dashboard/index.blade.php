@extends('layouts.app')

@section('title', __('messages.dashboard'))
@section('page-title', __('messages.dashboard'))

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">إجمالي العقارات</p>
                    <h3 class="mb-0 fw-bold">{{ $stats['total_properties'] }}</h3>
                </div>
                <div class="icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">عقارات متاحة</p>
                    <h3 class="mb-0 fw-bold text-success">{{ $stats['available_properties'] }}</h3>
                </div>
                <div class="icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">طلبات صيانة معلقة</p>
                    <h3 class="mb-0 fw-bold text-warning">{{ $stats['pending_maintenance'] }}</h3>
                </div>
                <div class="icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">المستخدمين</p>
                    <h3 class="mb-0 fw-bold text-info">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-users"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Properties -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="bi bi-building me-2 text-primary"></i>أحدث العقارات</h5>
                <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>الحالة</th>
                                <th>السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProperties as $property)
                            <tr>
                                <td>
                                    <a href="{{ route('properties.show', $property) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($property->title, 25) }}
                                    </a>
                                </td>
                                <td>
                                    @switch($property->type)
                                        @case('apartment') شقة @break
                                        @case('villa') فيلا @break
                                        @case('office') مكتب @break
                                        @case('land') أرض @break
                                        @case('building') مبنى @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($property->status)
                                        @case('available')
                                            <span class="badge bg-success">متاح</span>
                                            @break
                                        @case('rented')
                                            <span class="badge bg-info">مؤجر</span>
                                            @break
                                        @case('sold')
                                            <span class="badge bg-secondary">مباع</span>
                                            @break
                                        @case('maintenance')
                                            <span class="badge bg-warning">صيانة</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="fw-bold">{{ number_format($property->price) }} ر.س</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">لا توجد عقارات</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Maintenance -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0"><i class="bi bi-tools me-2 text-warning"></i>طلبات الصيانة</h5>
                <a href="{{ route('maintenance.index') }}" class="btn btn-sm btn-outline-warning">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>الطلب</th>
                                <th>الأولوية</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMaintenance as $request)
                            <tr>
                                <td>
                                    <a href="{{ route('maintenance.show', $request) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($request->title, 20) }}
                                    </a>
                                </td>
                                <td>
                                    @switch($request->priority)
                                        @case('low')
                                            <span class="badge bg-secondary">منخفضة</span>
                                            @break
                                        @case('medium')
                                            <span class="badge bg-info">متوسطة</span>
                                            @break
                                        @case('high')
                                            <span class="badge bg-warning">عالية</span>
                                            @break
                                        @case('urgent')
                                            <span class="badge bg-danger">عاجلة</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($request->status)
                                        @case('pending')
                                            <span class="badge bg-warning">معلق</span>
                                            @break
                                        @case('in_progress')
                                            <span class="badge bg-info">قيد التنفيذ</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">مكتمل</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-secondary">ملغي</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-muted">{{ $request->created_at->format('Y/m/d') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">لا توجد طلبات صيانة</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-bolt me-2" style="color: var(--primary-color)"></i>إجراءات سريعة</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('properties.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-plus-circle fa-2x d-block mb-2"></i>
                            إضافة عقار جديد
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('maintenance.create') }}" class="btn btn-outline-warning w-100 py-3">
                            <i class="bi bi-wrench fa-2x d-block mb-2"></i>
                            طلب صيانة
                        </a>
                    </div>
                    @can('view users')
                    <div class="col-md-3">
                        <a href="{{ route('users.create') }}" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-user-plus fa-2x d-block mb-2"></i>
                            إضافة مستخدم
                        </a>
                    </div>
                    @endcan
                    <div class="col-md-3">
                        <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary w-100 py-3">
                            <i class="bi bi-search fa-2x d-block mb-2"></i>
                            البحث في العقارات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
