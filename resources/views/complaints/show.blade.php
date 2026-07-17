@extends('layouts.app')

@section('title', 'تفاصيل الشكوى #' . $complaint->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Complaint Details -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <span class="badge {{ $complaint->type == 'complaint' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} me-2">
                        {{ $complaint->type_label }}
                    </span>
                    {{ $complaint->title }}
                </h5>
                <span class="badge bg-secondary">{{ $complaint->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-muted small">الوصف</h6>
                    <p class="lead fs-6">{{ $complaint->description }}</p>
                </div>
                
                @if($complaint->rejection_reason && $complaint->status == 'rejected')
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-x-circle me-1"></i> سبب الرفض:</strong>
                        <p class="mb-0 mt-1">{{ $complaint->rejection_reason }}</p>
                    </div>
                @endif
                
                @if($complaint->response)
                    <div class="alert alert-info">
                        <strong><i class="bi bi-reply-fill me-1"></i> الرد الرسمي:</strong>
                        <p class="mb-0 mt-1">{{ $complaint->response }}</p>
                    </div>
                @endif

                <div class="d-flex justify-content-between text-muted small mt-4 border-top pt-3">
                    <span><i class="bi bi-person me-1"></i> {{ $complaint->user->name }}</span>
                    <span><i class="bi bi-calendar me-1"></i> {{ $complaint->created_at->format('Y-m-d H:i') }}</span>
                    <span><i class="bi bi-flag me-1"></i> الأولوية: {{ $complaint->priority_label }}</span>
                </div>
            </div>
        </div>

        <!-- History Timeline -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>سجل النشاطات</h6>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    @forelse($complaint->history as $history)
                        <div class="timeline-item pb-4 position-relative border-start ps-4" style="border-color: #e9ecef !important;">
                            <div class="position-absolute start-0 top-0 translate-middle rounded-circle bg-white border border-2 border-primary d-flex align-items-center justify-content-center" style="width: 12px; height: 12px;"></div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-bold small">{{ $history->user->name ?? 'System' }}</span>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $history->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 small text-muted">{{ $history->description }}</p>
                        </div>
                    @empty
                        <p class="text-center text-muted small">لا يوجد سجل نشاطات</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Actions (Manager Only) -->
    <div class="col-md-4">
        @if(auth()->user()->hasRole(['Admin', 'Manager']))
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">إدارة الشكوى</h6>
                
                <!-- Assign Form -->
                <form action="{{ route('complaints.assign', $complaint) }}" method="POST" class="mb-3">
                    @csrf
                    <label class="form-label small text-muted">إسناد إلى</label>
                    <div class="input-group">
                        <select name="assigned_to" class="form-select form-select-sm" required>
                            <option value="">-- اختر موظف --</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ $complaint->assigned_to == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-outline-primary" type="submit">حفظ</button>
                    </div>
                </form>

                <hr>

                <!-- Status Update -->
                <form action="{{ route('complaints.update', $complaint) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">تحديث الحالة</label>
                        <select name="status" class="form-select form-select-sm mb-2">
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                            <option value="closed" {{ $complaint->status == 'closed' ? 'selected' : '' }}>مغلقة</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">إضافة رد</label>
                        <textarea name="response" class="form-control form-control-sm" rows="3" placeholder="اكتب ردك هنا...">{{ $complaint->response }}</textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">تحديث الحالة والرد</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            رفض الشكوى
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2">معلومات إضافية</h6>
                <ul class="list-unstyled small text-muted mb-0">
                    <li><strong>الموكل إليه:</strong> {{ $complaint->assignedTo->name ?? 'غير محدد' }}</li>
                    <li><strong>تاريخ الإنشاء:</strong> {{ $complaint->created_at->format('Y-m-d') }}</li>
                    <li><strong>آخر تحديث:</strong> {{ $complaint->updated_at->diffForHumans() }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('complaints.reject', $complaint) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fs-6">رفض الشكوى</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">سبب الرفض <span class="text-danger">*</span></label>
                    <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" class="btn btn-sm btn-danger">تأكيد الرفض</button>
            </div>
        </form>
    </div>
</div>
@endsection
