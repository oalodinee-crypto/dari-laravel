@extends('layouts.app')

@section('title', 'فواتيري')

@section('content')
<div class="mb-4">
    <h4 class="mb-0">
        <i class="bi bi-receipt me-2"></i>
        فواتيري
    </h4>
</div>

{{-- Summary Cards --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-4 border-danger">
            <p class="text-muted mb-1">المستحقة</p>
            <h3 class="text-danger">{{ number_format($invoices->where('status', 'pending')->sum('total_amount'), 2) }} <small>ر.س</small></h3>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-4 border-success">
            <p class="text-muted mb-1">المدفوعة</p>
            <h3 class="text-success">{{ number_format($invoices->where('status', 'paid')->sum('total_amount'), 2) }} <small>ر.س</small></h3>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-4 border-info">
            <p class="text-muted mb-1">إجمالي الفواتير</p>
            <h3>{{ $invoices->count() }}</h3>
        </div>
    </div>
</div>

{{-- Invoices List --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>الوصف</th>
                        <th>المبلغ</th>
                        <th>تاريخ الاستحقاق</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td><strong>{{ $invoice->invoice_number ?? '#' . $invoice->id }}</strong></td>
                        <td>{{ $invoice->description ?? 'إيجار شهري' }}</td>
                        <td>{{ number_format($invoice->total_amount ?? 0, 2) }} ر.س</td>
                        <td>{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '-' }}</td>
                        <td>
                            @switch($invoice->status)
                                @case('paid')
                                    <span class="badge bg-success">مدفوعة</span>
                                    @break
                                @case('pending')
                                    <span class="badge bg-warning">مستحقة</span>
                                    @break
                                @case('overdue')
                                    <span class="badge bg-danger">متأخرة</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $invoice->status }}</span>
                            @endswitch
                        </td>
                        <td>
                            @if($invoice->status != 'paid')
                                <a href="{{ route('resident.pay-online') }}" class="btn btn-sm btn-success">
                                    <i class="bi bi-credit-card me-1"></i>دفع الآن
                                </a>
                            @else
                                <a href="#" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-download me-1"></i>الإيصال
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">لا توجد فواتير</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
