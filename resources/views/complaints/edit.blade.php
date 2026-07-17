@extends('layouts.app')

@section('title', 'تعديل الشكوى')

@section('content')
<div class="mb-4">
    <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-right me-1"></i>
        العودة
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-pencil me-2"></i>
            تعديل الشكوى / إضافة رد
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('complaints.update', $complaint->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">العنوان</label>
                    <input type="text" name="title" id="title" class="form-control" 
                           value="{{ old('title', $complaint->title) }}" required>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="type" class="form-label">النوع</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="complaint" {{ $complaint->type == 'complaint' ? 'selected' : '' }}>شكوى</option>
                        <option value="suggestion" {{ $complaint->type == 'suggestion' ? 'selected' : '' }}>اقتراح</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="priority" class="form-label">الأولوية</label>
                    <select name="priority" id="priority" class="form-select" required>
                        <option value="low" {{ $complaint->priority == 'low' ? 'selected' : '' }}>منخفضة</option>
                        <option value="medium" {{ $complaint->priority == 'medium' ? 'selected' : '' }}>متوسطة</option>
                        <option value="high" {{ $complaint->priority == 'high' ? 'selected' : '' }}>عالية</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                    <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                    <option value="closed" {{ $complaint->status == 'closed' ? 'selected' : '' }}>مغلقة</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">التفاصيل</label>
                <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $complaint->description) }}</textarea>
            </div>
            
            <div class="mb-3">
                <label for="response" class="form-label">
                    <i class="bi bi-reply me-1"></i>
                    رد الإدارة
                </label>
                <textarea name="response" id="response" class="form-control" rows="4" 
                          placeholder="اكتب ردك على الشكوى هنا...">{{ old('response', $complaint->response) }}</textarea>
                <small class="text-muted">سيتم إشعار صاحب الشكوى عند إضافة رد أو تغيير الحالة</small>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    حفظ التغييرات
                </button>
                <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-secondary">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
