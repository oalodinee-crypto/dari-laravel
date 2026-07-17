@extends('layouts.app')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-eye me-2"></i>تفاصيل الطلب #{{ $request->id }}</h5>
            <a href="{{ route('resident.my-requests') }}" class="btn btn-secondary btn-sm">رجوع</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3"><strong>نوع الوحدة:</strong> {{ $request->unit_type }}</div>
                <div class="col-md-6 mb-3"><strong>عدد الغرف:</strong> {{ $request->rooms_count ?? '-' }}</div>
                <div class="col-md-6 mb-3"><strong>عدد الحمامات:</strong> {{ $request->bathrooms_count ?? '-' }}</div>
                <div class="col-md-6 mb-3"><strong>المساحة:</strong> {{ $request->area_required ?? '-' }} م²</div>
                <div class="col-md-6 mb-3"><strong>الطابق من:</strong> {{ $request->floor_from ?? '-' }}</div>
                <div class="col-md-6 mb-3"><strong>الطابق إلى:</strong> {{ $request->floor_to ?? '-' }}</div>
                <div class="col-md-6 mb-3"><strong>الميزانية:</strong> {{ $request->budget_min ?? '-' }} - {{ $request->budget_max ?? '-' }}</div>
                <div class="col-md-6 mb-3"><strong>تاريخ الانتقال:</strong> {{ $request->move_date ?? '-' }}</div>
                <div class="col-md-6 mb-3"><strong>رقم التواصل:</strong> {{ $request->contact_phone ?? '-' }}</div>
                <div class="col-md-6 mb-3"><strong>الحالة:</strong>
                    @if($request->status == 'pending')<span class="badge bg-warning">قيد المراجعة</span>
                    @elseif($request->status == 'approved')<span class="badge bg-success">مقبول</span>
                    @else<span class="badge bg-danger">مرفوض</span>@endif
                </div>
                <div class="col-12 mb-3"><strong>ملاحظات:</strong> {{ $request->notes ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
