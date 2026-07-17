@extends('layouts.app')

@section('title', 'تفاصيل الوحدة - ' . $unit->unit_number)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-door-open me-2"></i>{{ $unit->building->name }} - {{ $unit->unit_number }}
        </h1>
        <div>
            <a href="{{ route('units.edit', $unit) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>تعديل
            </a>
            <a href="{{ route('units.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-right me-1"></i>رجوع
            </a>
        </div>
    </div>

    <div class="row">
        <!-- معلومات الوحدة -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>معلومات الوحدة</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small">المبنى</label>
                            <p class="fw-bold">{{ $unit->building->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">رقم الوحدة</label>
                            <p class="fw-bold">{{ $unit->unit_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">الطابق</label>
                            <p class="fw-bold">{{ $unit->floor_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">النوع</label>
                            <p class="fw-bold">{{ $unit->type }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">المساحة</label>
                            <p class="fw-bold">{{ $unit->area }} م²</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">غرف النوم</label>
                            <p class="fw-bold">{{ $unit->bedrooms }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">الحمامات</label>
                            <p class="fw-bold">{{ $unit->bathrooms }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">قيمة الإيجار</label>
                            <p class="fw-bold text-success">{{ number_format($unit->rent_amount) }} ر.س</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">الحالة</label>
                            <p>
                                @if($unit->status == 'available')
                                    <span class="badge bg-success">متاحة</span>
                                @elseif($unit->status == 'occupied')
                                    <span class="badge bg-primary">مؤجرة</span>
                                @elseif($unit->status == 'maintenance')
                                    <span class="badge bg-warning">تحت الصيانة</span>
                                @else
                                    <span class="badge bg-secondary">محجوزة</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- معرض الصور -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-images me-2"></i>معرض الصور</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="bi bi-upload me-1"></i>رفع صور
                    </button>
                </div>
                <div class="card-body">
                    @if($unit->images && count($unit->images) > 0)
                        <div class="row g-2">
                            @foreach($unit->images as $image)
                                <div class="col-md-4 col-6">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded" style="height: 150px; width: 100%; object-fit: cover;">
                                        <form action="{{ route('units.delete-image', $unit) }}" method="POST" class="position-absolute top-0 end-0 m-1">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="image" value="{{ $image }}">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('حذف هذه الصورة؟')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">لا توجد صور</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- الشريط الجانبي -->
        <div class="col-lg-4">
            <!-- المستأجر -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>المستأجر الحالي</h5>
                </div>
                <div class="card-body">
                    @if($unit->tenant)
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                {{ mb_substr($unit->tenant->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $unit->tenant->name }}</h6>
                                <small class="text-muted">{{ $unit->tenant->phone }}</small>
                            </div>
                        </div>
                    @else
                        <p class="text-muted text-center">لا يوجد مستأجر</p>
                    @endif
                </div>
            </div>

            <!-- QR Code -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-qr-code me-2"></i>رمز QR</h5>
                </div>
                <div class="card-body text-center">
                    @if($unit->qr_code)
                        <img src="{{ asset('storage/' . $unit->qr_code) }}" class="img-fluid mb-3" style="max-width: 200px;">
                        <p class="small text-muted">امسح للوصول السريع للوحدة</p>
                    @else
                        <p class="text-muted mb-3">لم يتم إنشاء رمز QR بعد</p>
                        <form action="{{ route('units.generate-qr', $unit) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-qr-code me-1"></i>إنشاء رمز QR
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- إحصائيات سريعة -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>إحصائيات</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>العقود</span>
                        <span class="badge bg-primary">{{ $unit->contracts->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>الفواتير</span>
                        <span class="badge bg-info">{{ $unit->invoices->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>طلبات الصيانة</span>
                        <span class="badge bg-warning">{{ $unit->maintenanceRequests->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal رفع الصور -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">رفع صور للوحدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('units.upload-images', $unit) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">اختر الصور</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                        <small class="text-muted">يمكنك اختيار عدة صور (الحد الأقصى 5MB لكل صورة)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">رفع</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
