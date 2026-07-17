@extends('layouts.app')

@section('title', 'تعديل الإعلان')

@section('content')
<div class="mb-4">
    <a href="{{ route('announcements.show', $announcement->id) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-right me-1"></i>
        العودة
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-pencil me-2"></i>
            تعديل الإعلان
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="title" class="form-label">عنوان الإعلان <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $announcement->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="building_id" class="form-label">المبنى</label>
                    <select name="building_id" id="building_id" class="form-select">
                        <option value="">جميع المباني</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}" {{ $announcement->building_id == $building->id ? 'selected' : '' }}>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="type" class="form-label">نوع الإعلان <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="general" {{ $announcement->type == 'general' ? 'selected' : '' }}>عام</option>
                        <option value="maintenance" {{ $announcement->type == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                        <option value="emergency" {{ $announcement->type == 'emergency' ? 'selected' : '' }}>طوارئ</option>
                        <option value="event" {{ $announcement->type == 'event' ? 'selected' : '' }}>حدث/فعالية</option>
                        <option value="reminder" {{ $announcement->type == 'reminder' ? 'selected' : '' }}>تذكير</option>
                    </select>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="priority" class="form-label">الأولوية <span class="text-danger">*</span></label>
                    <select name="priority" id="priority" class="form-select" required>
                        <option value="low" {{ $announcement->priority == 'low' ? 'selected' : '' }}>منخفضة</option>
                        <option value="medium" {{ $announcement->priority == 'medium' ? 'selected' : '' }}>متوسطة</option>
                        <option value="high" {{ $announcement->priority == 'high' ? 'selected' : '' }}>عالية</option>
                        <option value="urgent" {{ $announcement->priority == 'urgent' ? 'selected' : '' }}>عاجلة</option>
                    </select>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="target" class="form-label">الفئة المستهدفة <span class="text-danger">*</span></label>
                    <select name="target" id="target" class="form-select" required>
                        <option value="all" {{ $announcement->target == 'all' ? 'selected' : '' }}>الجميع</option>
                        <option value="tenants" {{ $announcement->target == 'tenants' ? 'selected' : '' }}>السكان فقط</option>
                        <option value="owners" {{ $announcement->target == 'owners' ? 'selected' : '' }}>الملاك فقط</option>
                        <option value="staff" {{ $announcement->target == 'staff' ? 'selected' : '' }}>الموظفين</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">محتوى الإعلان <span class="text-danger">*</span></label>
                <textarea name="content" id="content" 
                          class="form-control @error('content') is-invalid @enderror" 
                          rows="6" required>{{ old('content', $announcement->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="expires_at" class="form-label">تاريخ الانتهاء</label>
                    <input type="date" name="expires_at" id="expires_at" class="form-control" 
                           value="{{ old('expires_at', $announcement->expires_at ? $announcement->expires_at->format('Y-m-d') : '') }}">
                </div>
                
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" 
                               {{ $announcement->is_active ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">الإعلان نشط</label>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    حفظ التغييرات
                </button>
                <a href="{{ route('announcements.show', $announcement->id) }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
