@extends('layouts.app')

@section('title', 'شكاوى ومقترحات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-chat-square-text me-2"></i>
        شكاوى ومقترحات
    </h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newComplaintModal">
        <i class="bi bi-plus-lg me-1"></i>
        شكوى جديدة
    </button>
</div>

<div class="card">
    <div class="card-body">
        @forelse($complaints as $complaint)
            <div class="card mb-3 border-start border-4 
                @if($complaint->status == 'resolved') border-success 
                @elseif($complaint->status == 'in_progress') border-info
                @else border-warning @endif">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge @if($complaint->type == 'complaint') bg-danger @else bg-info @endif mb-2">
                                {{ $complaint->type == 'complaint' ? 'شكوى' : 'مقترح' }}
                            </span>
                            <h5 class="mb-1">{{ $complaint->title }}</h5>
                            <p class="text-muted mb-2">{{ $complaint->description }}</p>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                {{ $complaint->created_at->format('Y-m-d') }}
                            </small>
                        </div>
                        <div class="text-end">
                            @switch($complaint->status)
                                @case('pending')
                                    <span class="badge bg-warning">قيد المراجعة</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-info">قيد المعالجة</span>
                                    @break
                                @case('resolved')
                                    <span class="badge bg-success">تم الحل</span>
                                    @break
                                @case('closed')
                                    <span class="badge bg-secondary">مغلقة</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    @if($complaint->response)
                        <div class="alert alert-success mt-3 mb-0">
                            <strong><i class="bi bi-reply me-2"></i>رد الإدارة:</strong>
                            <p class="mb-0 mt-2">{{ $complaint->response }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-chat-square-text text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">لا توجد شكاوى أو مقترحات</h5>
                <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#newComplaintModal">
                    <i class="bi bi-plus-lg me-1"></i>
                    تقديم شكوى أو مقترح
                </button>
            </div>
        @endforelse
    </div>
</div>

{{-- New Complaint Modal --}}
<div class="modal fade" id="newComplaintModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('resident.my-complaints.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>
                        شكوى / مقترح جديد
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">النوع</label>
                        <select class="form-select" name="type" required>
                            <option value="complaint">شكوى</option>
                            <option value="suggestion">مقترح</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الأولوية</label>
                        <select class="form-select" name="priority" required>
                            <option value="low">منخفضة</option>
                            <option value="medium" selected>متوسطة</option>
                            <option value="high">عالية</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" required placeholder="موضوع الشكوى...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">التفاصيل <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="4" required placeholder="اشرح المشكلة بالتفصيل..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>
                        إرسال
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
