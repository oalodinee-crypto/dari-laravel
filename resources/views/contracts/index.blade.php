@extends('layouts.app')

@section('title', __('messages.contracts'))

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-file-earmark-text me-2"></i> {{ __('messages.contracts') }}</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addContractModal">
            <i class="bi bi-plus"></i> {{ __('messages.add') }}
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>{{ __('messages.contract_number') }}</th>
                    <th>{{ __('messages.tenant') }}</th>
                    <th>{{ __('messages.unit') }}</th>
                    <th>{{ __('messages.building') }}</th>
                    <th>{{ __('messages.start_date') }}</th>
                    <th>{{ __('messages.end_date') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                <tr>
                    <td>{{ $contract->contract_number }}</td>
                    <td>{{ $contract->tenant->name ?? __('messages.not_specified') }}</td>
                    <td>{{ $contract->unit->unit_number ?? '-' }}</td>
                    <td>{{ $contract->unit->building->name ?? '-' }}</td>
                    <td>{{ $contract->start_date ? $contract->start_date->format('Y-m-d') : '-' }}</td>
                    <td>{{ $contract->end_date ? $contract->end_date->format('Y-m-d') : '-' }}</td>
                    <td>
                        @if($contract->status == 'active')
                            <span class="badge bg-success">{{ __('messages.active') }}</span>
                        @elseif($contract->status == 'expired')
                            <span class="badge bg-danger">{{ __('messages.expired') }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ __('messages.pending') }}</span>
                        @endif
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('contracts.destroy', $contract) }}" method="POST" class="d-inline confirm-delete">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">{{ __('messages.no_contracts') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($contracts, 'hasPages') && $contracts->hasPages())
    <div class="mt-3">{{ $contracts->links() }}</div>
    @endif
</div>

<!-- Add Contract Modal -->
<div class="modal fade" id="addContractModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.add_contract') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('contracts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.tenant') }}</label>
                        <select name="tenant_id" class="form-select" required>
                            <option value="">{{ __('messages.select_tenant') }}</option>
                            @foreach(\App\Models\User::whereHas('roles', function($q) { $q->where('name', 'Resident'); })->get() as $tenant)
                                <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.unit') }}</label>
                        <select name="unit_id" class="form-select" required>
                            <option value="">{{ __('messages.select_unit') }}</option>
                            @foreach(\App\Models\Unit::where('status', 'available')->with('building')->get() as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->building->name ?? '' }} - {{ $unit->unit_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.type') }}</label>
                            <select name="type" class="form-select" required>
                                <option value="rent">إيجار</option>
                                <option value="lease">تأجير</option>
                                <option value="sale">بيع</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.payment_frequency') }}</label>
                            <select name="payment_frequency" class="form-select" required>
                                <option value="monthly">شهري</option>
                                <option value="quarterly">ربع سنوي</option>
                                <option value="semi_annual">نصف سنوي</option>
                                <option value="annual">سنوي</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.start_date') }}</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.end_date') }}</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.monthly_rent') }}</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <input type="hidden" name="status" value="active">
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
