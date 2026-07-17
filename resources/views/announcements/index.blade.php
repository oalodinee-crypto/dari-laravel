@extends('layouts.app')

@section('title', __('messages.announcements'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-megaphone text-primary me-2"></i>
                    {{ __('messages.announcements') }}
                </h2>
                {{-- زر الإضافة للمدير فقط --}}
                @if(auth()->user()->hasAnyRole(['Manager', 'Admin']))
                <a href="{{ route('announcements.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus me-1"></i>
                    {{ __('messages.add_announcement') }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($announcements as $announcement)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center
                    @if($announcement->priority == 'high') bg-danger text-white
                    @elseif($announcement->priority == 'medium') bg-warning
                    @else bg-info text-white @endif">
                    <span>
                        @if($announcement->priority == 'high')
                            <i class="bi bi-exclamation-triangle me-1"></i> {{ __('messages.urgent') }}
                        @elseif($announcement->priority == 'medium')
                            <i class="bi bi-bell me-1"></i> {{ __('messages.medium') }}
                        @else
                            <i class="bi bi-info-circle me-1"></i> {{ __('messages.low') }}
                        @endif
                    </span>
                    <small>{{ $announcement->created_at->diffForHumans() }}</small>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $announcement->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($announcement->content, 150) }}</p>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-person me-1"></i>
                            {{ $announcement->createdBy->name ?? 'System' }}
                        </small>
                        
                        {{-- أزرار التعديل والحذف للمدير فقط --}}
                        @if(auth()->user()->hasAnyRole(['Manager', 'Admin']))
                        <div>
                            <a href="{{ route('announcements.edit', $announcement) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                        @else
                        {{-- للساكن: زر عرض التفاصيل فقط --}}
                        <a href="{{ route('announcements.show', $announcement) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye me-1"></i> عرض
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-megaphone" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">{{ __('messages.no_data') }}</h4>
                    @if(auth()->user()->hasAnyRole(['Manager', 'Admin']))
                    <a href="{{ route('announcements.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-plus me-1"></i>
                        {{ __('messages.add_announcement') }}
                    </a>
                    @else
                    <p class="text-muted">لا توجد إعلانات حالياً</p>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection+