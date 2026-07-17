@extends('layouts.app')

@section('title', 'الرسائل')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-chat-dots me-2"></i>
        الرسائل
    </h4>
    <a href="{{ route('messages.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>
        رسالة جديدة
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($conversations->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-chat-dots text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">لا توجد محادثات بعد</p>
                <a href="{{ route('messages.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-lg me-1"></i>
                    ابدأ محادثة جديدة
                </a>
            </div>
        @else
            <div class="list-group list-group-flush">
                @foreach($conversations as $userId => $message)
                    @php $otherUser = $users[$userId] ?? null; @endphp
                    @if($otherUser)
                        <a href="{{ route('messages.show', $userId) }}" 
                           class="list-group-item list-group-item-action d-flex align-items-center py-3 {{ !$message->is_read && $message->receiver_id == auth()->id() ? 'bg-light' : '' }}">
                            <div class="avatar-circle me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                {{ mb_substr($otherUser->name, 0, 1) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1 {{ !$message->is_read && $message->receiver_id == auth()->id() ? 'fw-bold' : '' }}">
                                        {{ $otherUser->name }}
                                    </h6>
                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 text-muted small text-truncate" style="max-width: 400px;">
                                    @if($message->sender_id == auth()->id())
                                        <span class="text-primary">أنت:</span>
                                    @endif
                                    {{ Str::limit($message->body, 50) }}
                                </p>
                            </div>
                            @if(!$message->is_read && $message->receiver_id == auth()->id())
                                <span class="badge bg-primary rounded-pill ms-2">جديد</span>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
