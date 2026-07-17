@extends('layouts.app')
@section('title', 'تفاصيل الدور')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="bi bi-shield me-2"></i>{{ $role->name }}</h1>
        <div>
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>تعديل</a>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-right me-1"></i>رجوع</a>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><h5 class="mb-0">الصلاحيات</h5></div>
        <div class="card-body">
            <div class="row">
                @foreach($role->permissions as $permission)
                <div class="col-md-3 mb-2"><span class="badge bg-primary">{{ $permission->name }}</span></div>
                @endforeach
            </div>
            @if($role->permissions->count() == 0)<p class="text-muted">لا توجد صلاحيات</p>@endif
        </div>
    </div>
</div>
@endsection
