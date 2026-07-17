@extends('layouts.app')
@section('title', 'تفاصيل المستخدم')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="bi bi-person me-2"></i>{{ $user->name }}</h1>
        <div>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>تعديل</a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-right me-1"></i>رجوع</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="text-muted small">الاسم</label><p class="fw-bold">{{ $user->name }}</p></div>
                        <div class="col-md-6"><label class="text-muted small">البريد</label><p class="fw-bold">{{ $user->email }}</p></div>
                        <div class="col-md-6"><label class="text-muted small">الهاتف</label><p class="fw-bold">{{ $user->phone ?? '-' }}</p></div>
                        <div class="col-md-6"><label class="text-muted small">الحالة</label><p><span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? 'نشط' : 'معطل' }}</span></p></div>
                        <div class="col-md-6"><label class="text-muted small">الدور</label><p><span class="badge bg-primary">{{ $user->roles->first()->name ?? '-' }}</span></p></div>
                        <div class="col-md-6"><label class="text-muted small">تاريخ التسجيل</label><p>{{ $user->created_at->format('Y-m-d') }}</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
