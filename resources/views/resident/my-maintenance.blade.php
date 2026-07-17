@extends('layouts.app')

@section('title', 'طلبات الصيانة')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-tools me-2"></i>
        طلبات الصيانة
    </h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRequestModal">
        <i class="bi bi-plus-lg me-1"></i>
        طلب جديد
    </button>
</div>

<div class="card">
    <div class="card-body">
        @forelse($requests as $request)
            <div class="card mb-3 border-start border-4 
                @if($request->status == 'completed') border-success 
                @elseif($request->status == 'in_progress') border-info
                @else border-warning @endif">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1">{{ $request->title }}</h5>
                            <p class="text-muted mb-2">{{ $request->description }}</p>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                {{ $request->created_at->format('Y-m-d') }}
                            </small>
                        </div>
                        <div class="text-end">
                            @switch($request->status)
                                @case('pending')
                                    <span class="badge bg-warning">قيد الانتظار</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-info">قيد التنفيذ</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-success">مكتمل</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-secondary">ملغي</span>
                                    @break
                            @endswitch
                            
                            @if($request->priority == 'urgent')
                                <span class="badge bg-danger ms-1">عاجل</span>
                            @elseif($request->priority == 'high')
                                <span class="badge bg-warning ms-1">مهم</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($request->notes)
                        <div class="alert alert-info mt-3 mb-0">
                            <strong><i class="bi bi-info-circle me-2"></i>ملاحظات:</strong>
                            <p class="mb-0 mt-1">{{ $request->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-tools text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">لا توجد طلبات صيانة</h5>
                <p class="text-muted">يمكنك تقديم طلب صيانة جديد</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newRequestModal">
                    <i class="bi bi-plus-lg me-1"></i>
                    طلب جديد
                </button>
            </div>
        @endforelse
    </div>
</div>

{{-- New Request Modal --}}
<div class="modal fade" id="newRequestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('maintenance.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>
                        طلب صيانة جديد
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @php
                        $contract = auth()->user()->contracts()->with('unit')->where('status', 'active')->first();
                        $property = $contract && $contract->unit ? \App\Models\Property::first() : null;
                    @endphp
                    
                    @if($property)
                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                    @else
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            لا يوجد لديك عقد نشط لتقديم طلب صيانة
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">عنوان الطلب <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" required placeholder="مثال: مشكلة في التكييف">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الأولوية</label>
                        <select class="form-select" name="priority" required>
                            <option value="low">منخفضة - يمكن الانتظار</option>
                            <option value="medium" selected>متوسطة - خلال أيام</option>
                            <option value="high">عالية - خلال يوم</option>
                            <option value="urgent">عاجلة - فوري</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تفاصيل المشكلة <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="4" required placeholder="اشرح المشكلة بالتفصيل..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary" {{ !$property ? 'disabled' : '' }}>
                        <i class="bi bi-send me-1"></i>
                        إرسال الطلب
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
