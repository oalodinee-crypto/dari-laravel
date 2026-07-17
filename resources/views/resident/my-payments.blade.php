@extends('layouts.app')

@section('title', 'مدفوعاتي')
@section('page-title', 'سجل المدفوعات')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="rounded-circle bg-white bg-opacity-25 p-3">
                                <i class="bi bi-wallet2 fs-2"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="mb-1">سجل مدفوعاتي</h4>
                            <p class="mb-0 opacity-75">جميع المدفوعات التي قمت بها</p>
                        </div>
                        <div class="col-auto">
                            <div class="text-end">
                                <p class="mb-0 small opacity-75">إجمالي المدفوعات</p>
                                <h3 class="mb-0">{{ number_format($payments->sum('amount') ?? 0) }} ر.ي</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="bi bi-list-check me-2"></i>قائمة المدفوعات</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>رقم السند</th>
                            <th>رقم الفاتورة</th>
                            <th>المبلغ</th>
                            <th>طريقة الدفع</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments ?? [] as $payment)
                        <tr>
                            <td class="fw-bold">{{ $payment->payment_number ?? '-' }}</td>
                            <td>{{ $payment->invoice->invoice_number ?? '-' }}</td>
                            <td class="text-success fw-bold">{{ number_format($payment->amount) }} ر.ي</td>
                            <td>
                                @php
                                    $methods = ['cash' => 'نقدي', 'bank_transfer' => 'تحويل بنكي', 'check' => 'شيك', 'wallet' => 'محفظة'];
                                    $icons = ['cash' => 'bi-cash', 'bank_transfer' => 'bi-bank', 'check' => 'bi-file-text', 'wallet' => 'bi-phone'];
                                @endphp
                                <i class="bi {{ $icons[$payment->payment_method] ?? 'bi-credit-card' }} me-1"></i>
                                {{ $methods[$payment->payment_method] ?? $payment->payment_method }}
                            </td>
                            <td>{{ $payment->payment_date?->format('Y-m-d') ?? '-' }}</td>
                            <td>
                                @if($payment->status == 'completed')
                                    <span class="badge bg-success">مكتمل</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge bg-warning">معلق</span>
                                @else
                                    <span class="badge bg-secondary">{{ $payment->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pdf.payment', $payment->id) }}" class="btn btn-sm btn-outline-primary" target="_blank" title="طباعة السند">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-wallet2 fs-1 d-block mb-3"></i>
                                    <p class="mb-0">لا توجد مدفوعات حتى الآن</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
