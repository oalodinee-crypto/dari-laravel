@extends('layouts.app')

@section('title', 'تعديل طلب الصيانة')
@section('page-title', 'تعديل طلب الصيانة')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('maintenance.update', $maintenance) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">عنوان الطلب <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $maintenance->title) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">وصف المشكلة <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $maintenance->description) }}</textarea>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الأولوية</label>
                            <select name="priority" class="form-select">
                                <option value="low" {{ old('priority', $maintenance->priority) == 'low' ? 'selected' : '' }}>منخفضة</option>
                                <option value="medium" {{ old('priority', $maintenance->priority) == 'medium' ? 'selected' : '' }}>متوسطة</option>
                                <option value="high" {{ old('priority', $maintenance->priority) == 'high' ? 'selected' : '' }}>عالية</option>
                                <option value="urgent" {{ old('priority', $maintenance->priority) == 'urgent' ? 'selected' : '' }}>عاجلة</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ old('status', $maintenance->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                <option value="in_progress" {{ old('status', $maintenance->status) == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                <option value="completed" {{ old('status', $maintenance->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="cancelled" {{ old('status', $maintenance->status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                        </div>
                    </div>
                    
                    @if($technicians->count() > 0)
                    <div class="mb-3 mt-3">
                        <label class="form-label fw-bold">تعيين فني</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">غير محدد</option>
                            @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ old('assigned_to', $maintenance->assigned_to) == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $maintenance->notes) }}</textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>حفظ التغييرات
                        </button>
                        <a href="{{ route('maintenance.show', $maintenance) }}" class="btn btn-secondary">
                            <i class="bi bi-times me-2"></i>إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
