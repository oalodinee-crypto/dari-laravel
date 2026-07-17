@extends('layouts.app')

@section('title', 'لوحة تحكم الساكن')
@section('page-title', 'لوحة تحكم الساكن')

@section('content')
<!-- Welcome Card -->
<div class="card mb-4" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">
    <div class="card-body text-white p-4">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                    <i class="bi bi-person-circle fs-1"></i>
                </div>
            </div>
            <div class="col">
                <h4 class="mb-1">مرحباً، {{ auth()->user()->name }}</h4>
                <p class="mb-0 opacity-75">
                    @if($myContract)
                        أنت مستأجر في {{ $myContract?->unit?->building->name ?? '' }} - وحدة {{ $myContract?->unit?->unit_number ?? '' }}
                    @else
                        لا يوجد عقد إيجار نشط حالياً
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card p-3 text-center h-100">
            <i class="bi bi-house-door fs-2 text-primary mb-2"></i>
            <h5 class="mb-1">{{ $myContract?->unit?->unit_number ?? '-' }}</h5>
            <small class="text-muted">رقم وحدتي</small>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card p-3 text-center h-100">
            <i class="bi bi-building fs-2 text-success mb-2"></i>
            <h5 class="mb-1">{{ $myContract?->unit?->building->name ?? '-' }}</h5>
            <small class="text-muted">المبنى</small>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card p-3 text-center h-100">
            <i class="bi bi-calendar-check fs-2 text-info mb-2"></i>
            <h5 class="mb-1">{{ $myContract?->end_date?->format('Y-m-d') ?? '-' }}</h5>
            <small class="text-muted">انتهاء العقد</small>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card p-3 text-center h-100">
            <i class="bi bi-cash-stack fs-2 text-warning mb-2"></i>
            <h5 class="mb-1">{{ number_format($myContract?->amount ?? 0) }} ر.ي</h5>
            <small class="text-muted">الإيجار الشهري</small>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Pending Invoices -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-receipt text-danger me-2"></i>فواتير معلقة</h6>
                <a href="{{ route('resident.my-invoices') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                @forelse($pendingInvoices as $invoice)
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <div>
                        <h6 class="mb-0">{{ $invoice->invoice_number }}</h6>
                        <small class="text-muted">استحقاق: {{ $invoice->due_date?->format('Y-m-d') }}</small>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-danger">{{ number_format($invoice->total_amount) }} ر.ي</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                    <p class="mt-2 mb-0">لا توجد فواتير معلقة</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- My Maintenance Requests -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-tools text-warning me-2"></i>طلبات الصيانة</h6>
                <a href="{{ route('resident.my-maintenance') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                @forelse($myMaintenance as $request)
                <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                    <div>
                        <h6 class="mb-0">{{ $request->title }}</h6>
                        <small class="text-muted">{{ $request->created_at?->diffForHumans() }}</small>
                    </div>
                    <span class="badge bg-{{ $request->status == 'completed' ? 'success' : ($request->status == 'in_progress' ? 'warning' : 'secondary') }}">
                        {{ $request->status == 'completed' ? 'مكتمل' : ($request->status == 'in_progress' ? 'قيد التنفيذ' : 'معلق') }}
                    </span>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-tools fs-1"></i>
                    <p class="mt-2 mb-0">لا توجد طلبات صيانة</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Announcements -->
<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0"><i class="bi bi-megaphone text-info me-2"></i>الإعلانات</h6>
    </div>
    <div class="card-body p-0">
        @forelse($announcements as $announcement)
        <div class="p-3 border-bottom">
            <div class="d-flex justify-content-between">
                <h6 class="mb-1">{{ $announcement->title }}</h6>
                <small class="text-muted">{{ $announcement->created_at?->diffForHumans() }}</small>
            </div>
            <p class="mb-0 text-muted small">{{ Str::limit($announcement->content, 150) }}</p>
        </div>
        @empty
        <div class="text-center py-4 text-muted">
            <p class="mb-0">لا توجد إعلانات</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mt-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('resident.my-invoices') }}" class="card p-3 text-center text-decoration-none h-100">
            <i class="bi bi-receipt fs-2 text-primary"></i>
            <p class="mb-0 mt-2">فواتيري</p>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('resident.my-payments') }}" class="card p-3 text-center text-decoration-none h-100">
            <i class="bi bi-wallet2 fs-2 text-success"></i>
            <p class="mb-0 mt-2">مدفوعاتي</p>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('resident.my-maintenance') }}" class="card p-3 text-center text-decoration-none h-100">
            <i class="bi bi-tools fs-2 text-warning"></i>
            <p class="mb-0 mt-2">طلب صيانة</p>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('resident.my-complaints') }}" class="card p-3 text-center text-decoration-none h-100">
            <i class="bi bi-chat-left-text fs-2 text-danger"></i>
            <p class="mb-0 mt-2">شكوى</p>
        </a>
    </div>
</div>
@endsection
