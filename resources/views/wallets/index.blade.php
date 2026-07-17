@extends('layouts.app')

@section('title', 'المحفظة الإلكترونية')

@section('content')
<div class="row">
    <!-- Wallet Cards Section (Horizontal Scroll) -->
    <div class="col-12 mb-4">
        <h4 class="mb-3"><i class="bi bi-wallet2 me-2"></i>محافظي</h4>
        
        <div class="d-flex overflow-auto pb-3 gap-3" style="scroll-behavior: smooth;">
            
            <!-- Main Wallet Card -->
            <div class="card bg-primary text-white border-0 shadow-sm" style="min-width: 300px; border-radius: 15px;">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-3 opacity-25">
                        <i class="bi bi-wallet2" style="font-size: 5rem;"></i>
                    </div>
                    <h6 class="card-subtitle mb-2 text-white-50">المحفظة الرئيسية</h6>
                    <h2 class="card-title fw-bold mb-4">{{ number_format($wallet->balance, 2) }} <small class="fs-6">{{ $wallet->currency }}</small></h2>
                    <div class="d-flex justify-content-between align-items-end">
                        <small class="text-white-50">رقم المحفظة: #{{ str_pad($wallet->id, 8, '0', STR_PAD_LEFT) }}</small>
                        <span class="badge bg-white text-primary rounded-pill px-3">{{ __('messages.active') }}</span>
                    </div>
                </div>
            </div>

            <!-- Points Wallet (Mockup for future) -->
            <div class="card bg-success text-white border-0 shadow-sm" style="min-width: 300px; border-radius: 15px;">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-3 opacity-25">
                        <i class="bi bi-star-fill" style="font-size: 5rem;"></i>
                    </div>
                    <h6 class="card-subtitle mb-2 text-white-50">نقاط دـاري</h6>
                    <h2 class="card-title fw-bold mb-4">0 <small class="fs-6">نقطة</small></h2>
                    <div class="d-flex justify-content-between align-items-end">
                        <small class="text-white-50">تستخدم للخصومات</small>
                        <button class="btn btn-sm btn-outline-light rounded-pill">قريباً</button>
                    </div>
                </div>
            </div>

            <!-- Add Funds Mockup -->
            <div class="card bg-light border-dashed shadow-sm d-flex align-items-center justify-content-center text-center" style="min-width: 150px; border-radius: 15px; border: 2px dashed #ccc; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#depositModal">
                <div class="card-body">
                    <i class="bi bi-plus-circle fs-1 text-primary mb-2 d-block"></i>
                    <span class="text-primary fw-bold">إيداع رصيد</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Actions & Recent Transactions -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>سجل العمليات</h5>
                <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-download me-1"></i>تصدير</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>النوع</th>
                            <th>المبلغ</th>
                            <th>الوصف</th>
                            <th>التاريخ</th>
                            <th>المرجع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>
                                @if($transaction->type == 'deposit')
                                    <span class="badge bg-success-subtle text-success rounded-pill"><i class="bi bi-arrow-down me-1"></i>إيداع</span>
                                @elseif($transaction->type == 'withdrawal')
                                    <span class="badge bg-danger-subtle text-danger rounded-pill"><i class="bi bi-arrow-up me-1"></i>سحب</span>
                                @elseif($transaction->type == 'payment')
                                    <span class="badge bg-danger-subtle text-danger rounded-pill"><i class="bi bi-credit-card me-1"></i>دفع</span>
                                @elseif($transaction->type == 'refund')
                                    <span class="badge bg-info-subtle text-info rounded-pill"><i class="bi bi-arrow-counterclockwise me-1"></i>استرداد</span>
                                @endif
                            </td>
                            <td class="fw-bold {{ in_array($transaction->type, ['deposit', 'refund']) ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->amount > 0 ? '+' : '' }}{{ number_format($transaction->amount, 2) }} SAR
                            </td>
                            <td>{{ $transaction->description }}</td>
                            <td class="text-muted small">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($transaction->reference_type)
                                    <span class="badge bg-secondary">Ref Link</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-wallet-8217316-6582643.png" alt="Empty" style="width: 100px; opacity: 0.5;">
                                <p class="text-muted mt-3">لا توجد عمليات مسجلة بعد</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($transactions->hasPages())
                <div class="card-footer bg-white">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-3">إجراءات سريعة</h6>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary text-start" data-bs-toggle="modal" data-bs-target="#depositModal">
                        <i class="bi bi-plus-lg me-2"></i>إيداع رصيد جديد
                    </button>
                    <button class="btn btn-outline-danger text-start" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                        <i class="bi bi-box-arrow-up-right me-2"></i>طلب سحب رصيد
                    </button>
                    <button class="btn btn-outline-info text-start">
                        <i class="bi bi-credit-card-2-front me-2"></i>إدارة البطاقات المحفوظة
                    </button>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm bg-info-subtle">
            <div class="card-body">
                <h6 class="card-title fw-bold mb-2 text-info-emphasis"><i class="bi bi-info-circle me-2"></i>معلومة</h6>
                <p class="small text-muted mb-0">يمكنك استخدام رصيد المحفظة لدفع الفواتير، الإيجارات، ورسوم الصيانة بشكل فوري دون الحاجة لبطاقة في كل مرة.</p>
            </div>
        </div>
    </div>
</div>

<!-- Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('wallet.deposit') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">إيداع رصيد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">المبلغ المراد إيداعه</label>
                    <div class="input-group">
                        <input type="number" name="amount" class="form-control" placeholder="0.00" min="1" step="0.01" required>
                        <span class="input-group-text">SAR</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">طريقة الدفع</label>
                    <select class="form-select">
                        <option>بطاقة مدى / ائتمانية (Mock)</option>
                        <option disabled>Apple Pay (Coming Soon)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-primary">إتمام الإيداع</button>
            </div>
        </form>
    </div>
</div>

<!-- Withdraw Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('wallet.withdraw') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">طلب سحب رصيد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning small">
                    <i class="bi bi-exclamation-triangle me-1"></i> سيتم تحويل المبلغ إلى حسابك البنكي المسجل خلال 24 ساعة عمل.
                </div>
                <div class="mb-3">
                    <label class="form-label">المبلغ المراد سحبه</label>
                    <div class="input-group">
                        <input type="number" name="amount" class="form-control" placeholder="0.00" min="10" max="{{ $wallet->balance }}" step="0.01" required>
                        <span class="input-group-text">SAR</span>
                    </div>
                    <small class="text-muted">الرصيد المتاح: {{ number_format($wallet->balance, 2) }} SAR</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-primary">تأكيد السحب</button>
            </div>
        </form>
    </div>
</div>
@endsection
