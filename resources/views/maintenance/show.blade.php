@extends('layouts.app')

@section('title', 'تفاصيل طلب الصيانة')
@section('page-title', 'تفاصيل طلب الصيانة')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">{{ $maintenance->title }}</h5>
                <span class="badge fs-6 
                    @switch($maintenance->status)
                        @case('pending') bg-warning @break
                        @case('in_progress') bg-info @break
                        @case('completed') bg-success @break
                        @case('cancelled') bg-secondary @break
                    @endswitch
                ">{{ $maintenance->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="text-muted">الوصف</h6>
                    <p>{{ $maintenance->description }}</p>
                </div>
                
                @if($maintenance->images && count($maintenance->images) > 0)
                <div class="mb-4">
                    <h6 class="text-muted">الصور المرفقة</h6>
                    <div class="row g-2">
                        @foreach($maintenance->images as $image)
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded" alt="صورة">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                @if($maintenance->notes)
                <div class="mb-4">
                    <h6 class="text-muted">ملاحظات</h6>
                    <p>{{ $maintenance->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Info Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="text-muted mb-3">معلومات الطلب</h6>
                
                <div class="mb-3">
                    <small class="text-muted d-block">العقار</small>
                    <strong>{{ $maintenance->property->title ?? '-' }}</strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block">مقدم الطلب</small>
                    <strong>{{ $maintenance->user->name ?? '-' }}</strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block">الأولوية</small>
                    <span class="badge 
                        @switch($maintenance->priority)
                            @case('low') bg-secondary @break
                            @case('medium') bg-info @break
                            @case('high') bg-warning @break
                            @case('urgent') bg-danger @break
                        @endswitch
                    ">{{ $maintenance->priority_label }}</span>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block">الفني المسؤول</small>
                    <strong>{{ $maintenance->assignedTo->name ?? 'غير محدد' }}</strong>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block">تاريخ الإنشاء</small>
                    <strong>{{ $maintenance->created_at->format('Y/m/d H:i') }}</strong>
                </div>
                
                @if($maintenance->completed_at)
                <div class="mb-3">
                    <small class="text-muted d-block">تاريخ الإكمال</small>
                    <strong>{{ $maintenance->completed_at->format('Y/m/d H:i') }}</strong>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Actions -->
        @can('edit maintenance')
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted mb-3">تحديث الحالة</h6>
                <form action="{{ route('maintenance.status', $maintenance) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="form-select mb-3">
                        <option value="pending" {{ $maintenance->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="in_progress" {{ $maintenance->status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                        <option value="completed" {{ $maintenance->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                        <option value="cancelled" {{ $maintenance->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-sync me-2"></i>تحديث الحالة
                    </button>
                </form>
                
                <hr>
                
                <a href="{{ route('maintenance.edit', $maintenance) }}" class="btn btn-outline-warning w-100 mb-2">
                    <i class="bi bi-edit me-2"></i>تعديل الطلب
                </a>
            </div>
        </div>
        @endcan
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('maintenance.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
    </a>
</div>
@endsection
