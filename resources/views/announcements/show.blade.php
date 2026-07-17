@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-right me-1"></i>
        العودة للإعلانات
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-megaphone me-2"></i>
            {{ $announcement->title }}
        </h5>
        <div class="d-flex gap-2">
            @if($announcement->priority == 'urgent')
                <span class="badge bg-danger">عاجل</span>
            @elseif($announcement->priority == 'high')
                <span class="badge bg-warning">مهم</span>
            @endif
            <span class="badge bg-secondary">{{ $announcement->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <div class="d-flex align-items-center gap-3 text-muted mb-3">
                <span><i class="bi bi-person me-1"></i> {{ $announcement->createdBy->name ?? 'الإدارة' }}</span>
                <span><i class="bi bi-calendar me-1"></i> {{ $announcement->created_at->format('Y/m/d') }}</span>
                @if($announcement->building)
                    <span><i class="bi bi-building me-1"></i> {{ $announcement->building->name }}</span>
                @endif
            </div>
        </div>
        
        <div class="announcement-content" style="line-height: 1.8; font-size: 1.05rem;">
            {!! nl2br(e($announcement->content)) !!}
        </div>
        
        @if($announcement->expires_at)
            <div class="mt-4 text-muted">
                <i class="bi bi-clock me-1"></i>
                ينتهي في: {{ $announcement->expires_at->format('Y/m/d') }}
            </div>
        @endif
    </div>
    
    @if(auth()->user()->hasRole(['Admin', 'Manager']))
    <div class="card-footer d-flex gap-2">
        <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> تعديل
        </a>
        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" class="confirm-delete">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash me-1"></i> حذف
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
