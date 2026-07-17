@extends('layouts.app')

@section('title', __('messages.buildings'))

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-building me-2"></i> {{ __('messages.buildings') }}</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBuildingModal">
            <i class="bi bi-plus"></i> {{ __('messages.add_building') }}
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="buildingsTable">
            <thead>
                <tr>
                    <th>{{ __('messages.building_name') }}</th>
                    <th>{{ __('messages.building_address') }}</th>
                    <th>{{ __('messages.units_count') }}</th>
                    <th>{{ __('messages.manager') }}</th>
                    <th>{{ __('messages.rent_arrears') }}</th>
                    <th>{{ __('messages.pending_bills') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buildings as $building)
                <tr>
                    <td>{{ $building->name }}</td>
                    <td>{{ $building->city }} - {{ $building->district ?? $building->address }}</td>
                    <td>{{ $building->units_count ?? $building->units->count() }}</td>
                    <td>{{ $building->manager->name ?? '-' }}</td>
                    <td>
                        @php
                            $rentArrears = $building->units->sum(function($unit) {
                                return $unit->contracts->where('status', 'active')->sum('arrears') ?? 0;
                            });
                        @endphp
                        @if($rentArrears > 0)
                            <span class="badge bg-danger">{{ number_format($rentArrears) }}</span>
                        @else
                            <span class="badge bg-success">{{ __('messages.no_arrears') }}</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $pendingBills = $building->units->sum(function($unit) {
                                return $unit->invoices->where('status', 'pending')->sum('total_amount') ?? 0;
                            });
                        @endphp
                        @if($pendingBills > 0)
                            <span class="badge bg-warning text-dark">{{ number_format($pendingBills) }}</span>
                        @else
                            <span class="badge bg-success">{{ __('messages.all_paid') }}</span>
                        @endif
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('buildings.show', $building) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('buildings.edit', $building) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('buildings.destroy', $building) }}" method="POST" class="d-inline confirm-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="bi bi-building fs-1 text-muted"></i>
                        <p class="text-muted mt-2">{{ __('messages.no_buildings') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($buildings->hasPages())
    <div class="mt-3">
        {{ $buildings->links() }}
    </div>
    @endif
</div>

<!-- Add Building Modal -->
<div class="modal fade" id="addBuildingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('messages.add_new_building') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('buildings.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.building_name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.code') }}</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.city') }}</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.area') }}</label>
                            <input type="text" name="district" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.building_address') }}</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.floors_count') }}</label>
                            <input type="number" name="floors_count" class="form-control" min="1" value="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.year_built') }}</label>
                            <input type="number" name="year_built" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.manager') }}</label>
                        <select name="manager_id" class="form-select">
                            <option value="">{{ __('messages.select_manager') }}</option>
                            @foreach(\App\Models\User::whereHas('roles', function($q) { $q->whereIn('name', ['Admin', 'Manager']); })->get() as $manager)
                                <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.status') }}</label>
                        <select name="status" class="form-select" required>
                            <option value="active">{{ __('messages.active') }}</option>
                            <option value="maintenance">{{ __('messages.maintenance') }}</option>
                            <option value="inactive">{{ __('messages.inactive') }}</option>
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
