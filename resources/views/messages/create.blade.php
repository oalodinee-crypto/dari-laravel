@extends('layouts.app')

@section('title', 'رسالة جديدة')

@section('content')
<div class="mb-4">
    <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-right me-1"></i>
        العودة للرسائل
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-envelope-plus me-2"></i>
            إرسال رسالة جديدة
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('messages.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="receiver_id" class="form-label">إرسال إلى <span class="text-danger">*</span></label>
                <select name="receiver_id" id="receiver_id" class="form-select @error('receiver_id') is-invalid @enderror" required>
                    <option value="">-- اختر المستلم --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                            @if($user->hasRole('Manager'))
                                (مالك/مدير)
                            @elseif($user->hasRole('Resident'))
                                (ساكن)
                            @elseif($user->hasRole('Admin'))
                                (مدير النظام)
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('receiver_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="subject" class="form-label">الموضوع</label>
                <input type="text" 
                       name="subject" 
                       id="subject" 
                       class="form-control @error('subject') is-invalid @enderror"
                       value="{{ old('subject') }}"
                       placeholder="موضوع الرسالة (اختياري)">
                @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="body" class="form-label">الرسالة <span class="text-danger">*</span></label>
                <textarea name="body" 
                          id="body" 
                          class="form-control @error('body') is-invalid @enderror"
                          rows="5"
                          placeholder="اكتب رسالتك هنا..."
                          required>{{ old('body') }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>
                    إرسال الرسالة
                </button>
                <a href="{{ route('messages.index') }}" class="btn btn-secondary">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
