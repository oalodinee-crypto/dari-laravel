@extends('layouts.app')

@section('title', __('messages.maintenance_requests'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">{{ __('messages.maintenance_requests') }}</h4>
    <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
        <i class="bi bi-plus me-2"></i>{{ __('messages.add_maintenance') }}
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('messages.name') }}</th>
                        <th>{{ __('messages.unit') }}</th>
                        <th>{{ __('messages.user') }}</th>
                        <th>{{ __('messages.priority') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th>{{ __('messages.date') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenance as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>
                            <a href="{{ route('maintenance.show', $request) }}" class="text-decoration-none">
                                {{ Str::limit($request->title, 30) }}
                            </a>
                        </td>
                        <td>{{ Str::limit($request->property->title ?? '-', 20) }}</td>
                        <td>{{ $request->user->name ?? '-' }}</td>
                        <td>
                            <span class="badge 
                                @switch($request->priority)
                                    @case('low') bg-secondary @break
                                    @case('medium') bg-info @break
                                    @case('high') bg-warning @break
                                    @case('urgent') bg-danger @break
                                @endswitch
                            ">
                                @switch($request->priority)
                                    @case('low') {{ __('messages.low') }} @break
                                    @case('medium') {{ __('messages.medium') }} @break
                                    @case('high') {{ __('messages.high') }} @break
                                    @case('urgent') {{ __('messages.urgent') }} @break
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                @switch($request->status)
                                    @case('pending') bg-warning @break
                                    @case('in_progress') bg-info @break
                                    @case('completed') bg-success @break
                                    @case('cancelled') bg-secondary @break
                                @endswitch
                            ">
                                @switch($request->status)
                                    @case('pending') {{ __('messages.pending') }} @break
                                    @case('in_progress') {{ __('messages.in_progress') }} @break
                                    @case('completed') {{ __('messages.completed') }} @break
                                    @default {{ $request->status }}
                                @endswitch
                            </span>
                        </td>
                        <td>{{ $request->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('maintenance.show', $request) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('maintenance.edit', $request) }}" class="btn btn-outline-warning">
                                    <i class="bi bi-edit"></i>
                                </a>
                                <form action="{{ route('maintenance.destroy', $request) }}" method="POST" class="d-inline confirm-delete">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">{{ __('messages.no_data') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $maintenance->links() }}
</div>
@endsection
