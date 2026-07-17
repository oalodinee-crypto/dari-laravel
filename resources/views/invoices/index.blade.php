@extends('layouts.app')

@section('title', __('messages.invoices'))

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5><i class="bi bi-receipt me-2"></i> {{ __('messages.invoices') }}</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBillModal">
            <i class="bi bi-plus"></i> {{ __('messages.add_invoice') }}
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>{{ __('messages.tenant') }}</th>
                    <th>{{ __('messages.unit') }}</th>
                    <th>{{ __('messages.building') }}</th>
                    <th>{{ __('messages.type') }}</th>
                    <th>{{ __('messages.amount') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->tenant->name ?? ($invoice->contract->tenant->name ?? '-') }}</td>
                    <td>{{ $invoice->unit->unit_number ?? ($invoice->contract->unit->unit_number ?? '-') }}</td>
                    <td>{{ $invoice->unit->building->name ?? ($invoice->contract->unit->building->name ?? '-') }}</td>
                    <td>{{ $invoice->type }}</td>
                    <td>{{ number_format($invoice->total_amount ?? $invoice->amount) }}</td>
                    <td>{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : $invoice->created_at->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : 'danger' }}">
                            {{ $invoice->status == 'paid' ? __('messages.paid') : __('messages.unpaid') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline confirm-delete">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">{{ __('messages.no_invoices') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($invoices, 'hasPages') && $invoices->hasPages())
    <div class="mt-3">{{ $invoices->links() }}</div>
    @endif
</div>

<!-- Add Bill Modal -->
<div class="modal fade" id="addBillModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.add_invoice') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.unit') }}</label>
                        <select name="unit_id" class="form-select" required>
                            @foreach(\App\Models\Unit::with('building')->get() as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->building->name ?? '' }} - {{ $unit->unit_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.type') }}</label>
                        <select name="type" class="form-select" required>
                            <option value="rent">{{ __('messages.rent_amount') }}</option>
                            <option value="utilities">{{ __('messages.maintenance') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.details') }}</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.amount') }}</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.issue_date') }}</label>
                            <input type="date" name="issue_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.due_date') }}</label>
                            <input type="date" name="due_date" class="form-control" required>
                        </div>
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
