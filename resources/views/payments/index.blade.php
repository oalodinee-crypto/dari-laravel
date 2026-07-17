@extends('layouts.app')

@section('title', __('messages.payments'))

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-cash-stack me-2"></i> {{ __('messages.payments') }}</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
            <i class="bi bi-plus"></i> {{ __('messages.add') }}
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.tenant') }}</th>
                    <th>{{ __('messages.building') }}</th>
                    <th>{{ __('messages.type') }}</th>
                    <th>{{ __('messages.amount') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->tenant->name ?? ($payment->invoice->tenant->name ?? '-') }}</td>
                    <td>{{ $payment->invoice->unit->building->name ?? '-' }}</td>
                    <td>{{ $payment->payment_type ?? __('messages.rent_amount') }}</td>
                    <td class="text-success fw-bold">{{ number_format($payment->amount) }}</td>
                    <td>{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : $payment->created_at->format('Y-m-d') }}</td>
                    <td><span class="badge bg-success">{{ __('messages.paid') }}</span></td>
                    <td>
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline confirm-delete">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">{{ __('messages.no_payments') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($payments, 'hasPages') && $payments->hasPages())
    <div class="mt-3">{{ $payments->links() }}</div>
    @endif
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.add_payment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.invoice') }}</label>
                        <select name="invoice_id" class="form-select" required>
                            <option value="">-- {{ __('messages.invoice') }} --</option>
                            @foreach(\App\Models\Invoice::where('status', '!=', 'paid')->with('tenant')->get() as $invoice)
                                <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }} - {{ $invoice->tenant->name ?? '-' }} ({{ number_format($invoice->total_amount) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.amount') }}</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.payment_method') }}</label>
                        <select name="method" class="form-select" required>
                            <option value="cash">{{ __('messages.cash') }}</option>
                            <option value="bank_transfer">{{ __('messages.bank_transfer') }}</option>
                            <option value="check">{{ __('messages.check') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.date') }}</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
