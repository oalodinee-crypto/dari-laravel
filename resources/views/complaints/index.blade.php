@extends('layouts.app')

@section('title', __('messages.complaints'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-chat-left-text text-primary me-2"></i>
                    {{ __('messages.complaints') }}
                </h2>
                <a href="{{ route('complaints.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus me-1"></i>
                    {{ __('messages.add_complaint') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h3>{{ $complaints->where('status', 'pending')->count() }}</h3>
                    <p class="mb-0">{{ __('messages.pending') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3>{{ $complaints->where('status', 'in_progress')->count() }}</h3>
                    <p class="mb-0">{{ __('messages.in_progress') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ $complaints->where('status', 'resolved')->count() }}</h3>
                    <p class="mb-0">{{ __('messages.resolved') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <h3>{{ $complaints->count() }}</h3>
                    <p class="mb-0">{{ __('messages.total') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.user') }}</th>
                            <th>{{ __('messages.type') }}</th>
                            <th>{{ __('messages.priority') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::limit($complaint->title, 30) }}</td>
                            <td>{{ $complaint->user->name ?? '-' }}</td>
                            <td>
                                @if($complaint->type == 'complaint')
                                    <span class="badge bg-danger">{{ __('messages.complaint') }}</span>
                                @else
                                    <span class="badge bg-info">{{ __('messages.suggestion') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($complaint->priority == 'high')
                                    <span class="badge bg-danger">{{ __('messages.high') }}</span>
                                @elseif($complaint->priority == 'medium')
                                    <span class="badge bg-warning">{{ __('messages.medium') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('messages.low') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($complaint->status == 'pending')
                                    <span class="badge bg-warning">{{ __('messages.pending') }}</span>
                                @elseif($complaint->status == 'in_progress')
                                    <span class="badge bg-info">{{ __('messages.in_progress') }}</span>
                                @elseif($complaint->status == 'resolved')
                                    <span class="badge bg-success">{{ __('messages.resolved') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('messages.completed') }}</span>
                                @endif
                            </td>
                            <td>{{ $complaint->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('complaints.edit', $complaint) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('complaints.destroy', $complaint) }}" method="POST" class="d-inline" id="formDeleteComplaint{{ $complaint->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="Swal.fire({title:'تأكيد الحذف',text:'هل تريد حذف هذه الشكوى؟',icon:'warning',showCancelButton:true,confirmButtonColor:'#d33',cancelButtonColor:'#3085d6',confirmButtonText:'نعم، حذف',cancelButtonText:'تراجع'}).then((result)=>{if(result.isConfirmed){document.getElementById('formDeleteComplaint{{ $complaint->id }}').submit();}})"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-chat-left-text fa-3x text-muted mb-3"></i>
                                <p class="text-muted">{{ __('messages.no_data') }}</p>
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