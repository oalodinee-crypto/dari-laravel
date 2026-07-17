@extends('layouts.app')

@section('title', 'محادثة مع ' . $otherUser->name)

@push('styles')
<style>
    .chat-container {
        height: calc(100vh - 350px);
        min-height: 400px;
        overflow-y: auto;
        padding: 20px;
        background: var(--bg-color);
        border-radius: 15px;
    }
    .message-bubble {
        max-width: 70%;
        padding: 12px 18px;
        border-radius: 18px;
        margin-bottom: 10px;
        position: relative;
    }
    .message-sent {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        margin-right: auto;
        border-bottom-left-radius: 5px;
    }
    .message-received {
        background: var(--card-bg);
        color: var(--text-color);
        margin-left: auto;
        border-bottom-right-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .message-time {
        font-size: 0.7rem;
        opacity: 0.7;
        margin-top: 5px;
    }
    .chat-input-container {
        background: var(--card-bg);
        border-radius: 25px;
        padding: 8px;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
    }
    .chat-input {
        border: none;
        background: transparent;
        resize: none;
        max-height: 100px;
    }
    .chat-input:focus {
        box-shadow: none;
        outline: none;
    }
    .send-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .send-btn:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<div class="mb-4">
    <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-right me-1"></i>
        العودة للرسائل
    </a>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center py-3">
        <div class="avatar-circle me-3" style="width: 45px; height: 45px;">
            {{ mb_substr($otherUser->name, 0, 1) }}
        </div>
        <div>
            <h5 class="mb-0">{{ $otherUser->name }}</h5>
            <small class="text-muted">
                @if($otherUser->hasRole('Manager'))
                    مالك/مدير
                @elseif($otherUser->hasRole('Resident'))
                    ساكن
                @else
                    مستخدم
                @endif
            </small>
        </div>
    </div>
    
    <div class="chat-container" id="chatContainer">
        @forelse($messages as $message)
            <div class="d-flex {{ $message->sender_id == auth()->id() ? 'justify-content-start' : 'justify-content-end' }}">
                <div class="message-bubble {{ $message->sender_id == auth()->id() ? 'message-sent' : 'message-received' }}">
                    <div>{{ $message->body }}</div>
                    <div class="message-time text-{{ $message->sender_id == auth()->id() ? 'light' : 'muted' }}">
                        {{ $message->created_at->format('h:i A') }}
                        @if($message->sender_id == auth()->id() && $message->is_read)
                            <i class="bi bi-check2-all ms-1"></i>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
                <p class="mt-2">ابدأ المحادثة الآن</p>
            </div>
        @endforelse
    </div>
    
    <div class="card-footer p-3">
        <form action="{{ route('messages.reply', $otherUser->id) }}" method="POST" id="replyForm">
            @csrf
            <div class="chat-input-container d-flex align-items-center gap-2">
                <textarea name="body" 
                          class="form-control chat-input" 
                          placeholder="اكتب رسالتك هنا..."
                          rows="1"
                          required
                          id="messageInput"></textarea>
                <button type="submit" class="send-btn">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // التمرير لآخر رسالة
    const chatContainer = document.getElementById('chatContainer');
    chatContainer.scrollTop = chatContainer.scrollHeight;
    
    // إرسال بالضغط على Enter
    document.getElementById('messageInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('replyForm').submit();
        }
    });
</script>
@endpush
@endsection
