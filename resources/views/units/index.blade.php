@extends('layouts.app')

@section('title', __('messages.units'))

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-door-open me-2"></i> {{ __('messages.units') }}</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUnitModal">
            <i class="bi bi-plus"></i> {{ __('messages.add') }}
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>{{ __('messages.unit_number') }}</th>
                    <th>{{ __('messages.building') }}</th>
                    <th>{{ __('messages.type') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.rent_amount') }}</th>
                    <th>{{ __('messages.tenant') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($units as $unit)
                <tr>
                    <td>{{ $unit->unit_number }}</td>
                    <td>{{ $unit->building->name ?? '-' }}</td>
                    <td>
                        @switch($unit->type)
                            @case('apartment') {{ __('messages.apartment') }} @break
                            @case('studio') {{ __('messages.studio') }} @break
                            @case('office') {{ __('messages.office') }} @break
                            @case('shop') {{ __('messages.shop') }} @break
                            @case('storage') {{ __('messages.storage') }} @break
                            @default {{ $unit->type }}
                        @endswitch
                    </td>
                    <td>
                        <span class="badge bg-{{ $unit->status == 'occupied' ? 'success' : ($unit->status == 'available' ? 'warning' : 'secondary') }}">
                            {{ $unit->status == 'occupied' ? __('messages.occupied') : ($unit->status == 'available' ? __('messages.vacant') : __('messages.maintenance')) }}
                        </span>
                    </td>
                    <td>{{ number_format($unit->amount ?? $unit->rent_amount ?? 0) }}</td>
                    <td>{{ $unit->tenant->name ?? '-' }}</td>
                    <td class="table-actions">
                        <a href="{{ route('units.edit', $unit) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('units.destroy', $unit) }}" method="POST" class="d-inline confirm-delete">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">{{ __('messages.no_units') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($units->hasPages())
    <div class="mt-3">{{ $units->links() }}</div>
    @endif
</div>

<!-- Add Unit Modal -->
<div class="modal fade" id="addUnitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.add_unit') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('units.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.unit_number') }}</label>
                        <input type="text" name="unit_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.building') }}</label>
                        <select name="building_id" class="form-select" required>
                            @foreach(\App\Models\Building::all() as $building)
                                <option value="{{ $building->id }}">{{ $building->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.floor_number') }}</label>
                            <input type="number" name="floor_number" class="form-control" value="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.type') }}</label>
                            <select name="type" class="form-select" required>
                                <option value="apartment">{{ __('messages.apartment') }}</option>
                                <option value="studio">{{ __('messages.studio') }}</option>
                                <option value="office">{{ __('messages.office') }}</option>
                                <option value="shop">{{ __('messages.shop') }}</option>
                                <option value="storage">{{ __('messages.storage') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.monthly_rent') }}</label>
                        <input type="number" name="rent_amount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.status') }}</label>
                        <select name="status" class="form-select" required>
                            <option value="available">{{ __('messages.vacant') }}</option>
                            <option value="occupied">{{ __('messages.occupied') }}</option>
                            <option value="maintenance">{{ __('messages.maintenance') }}</option>
                            <option value="reserved">{{ __('messages.reserved') }}</option>
                        </select>
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
