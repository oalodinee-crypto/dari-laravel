@extends('layouts.app')

@section('title', 'الإشعارات')
@section('page-title', 'الإشعارات')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-bell me-2"></i>جميع الإشعارات</h5>
        @if($notifications->where('read_at', null)->count() > 0)
        <form action="{{ route('notifications.markAllRead') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check-all me-1"></i>تحديد الكل كمقروء
            </button>
        </form>
        @endif
    </div>
    <div class="card-body p-0">
        @forelse($notifications as $notification)
        <div class="d-flex align-items-start p-3 border-bottom {{ $notification->read_at ? '' : 'bg-light' }}">
            <div class="me-3">
                @switch($notification->type)
                    @case('payment')
                        <div class="rounded-circle bg-success bg-opacity-10 p-2"><i class="bi bi-wallet2 text-success"></i></div>
                        @break
                    @case('contract')
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2"><i class="bi bi-file-text text-primary"></i></div>
                        @break
                    @case('maintenance')
                    @case('maintenance_update')
                        <div class="rounded-circle bg-warning bg-opacity-10 p-2"><i class="bi bi-tools text-warning"></i></div>
                        @break
                    @case('complaint')
                    @case('complaint_update')
                        <div class="rounded-circle bg-danger bg-opacity-10 p-2"><i class="bi bi-exclamation-triangle text-danger"></i></div>
                        @break
                    @case('message')
                        <div class="rounded-circle bg-info bg-opacity-10 p-2"><i class="bi bi-envelope text-info"></i></div>
                        @break
                    @case('announcement')
                        <div class="rounded-circle bg-purple bg-opacity-10 p-2" style="background: rgba(102,126,234,0.1);"><i class="bi bi-megaphone" style="color: #667eea;"></i></div>
                        @break
                    @default
                        <div class="rounded-circle bg-secondary bg-opacity-10 p-2"><i class="bi bi-bell text-secondary"></i></div>
                @endswitch
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-1 {{ $notification->read_at ? '' : 'fw-bold' }}">{{ $notification->title }}</h6>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1 text-muted small">{{ $notification->message }}</p>
                <div class="d-flex gap-2">
                    @if($notification->action_url)
                    <a href="{{ $notification->action_url }}" class="btn btn-sm btn-outline-primary">عرض</a>
                    @endif
                    @if(!$notification->read_at)
                    <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">تحديد كمقروء</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="bi bi-bell-slash fs-1 mb-3 d-block"></i>
            <p>لا توجد إشعارات</p>
        </div>
        @endforelse
    </div>
    @if($notifications->hasPages())
    <div class="card-footer">
        {{ $notifications->links() }}
    </div>
    @endif
</div>
@endsection
