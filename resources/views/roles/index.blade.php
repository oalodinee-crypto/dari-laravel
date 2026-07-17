@extends('layouts.app')

@section('title', 'الأدوار والصلاحيات')
@section('page-title', 'إدارة الأدوار والصلاحيات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">الأدوار والصلاحيات</h4>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus me-2"></i>إضافة دور جديد
    </a>
</div>

<div class="row g-4">
    @foreach($roles as $role)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-user-shield me-2 text-primary"></i>
                    @switch($role->name)
                        @case('admin') مدير النظام @break
                        @case('manager') مشرف @break
                        @case('technician') فني صيانة @break
                        @case('user') مستخدم عادي @break
                        @default {{ $role->name }}
                    @endswitch
                </h5>
                <span class="badge bg-secondary">{{ $role->users()->count() }} مستخدم</span>
            </div>
            <div class="card-body">
                <h6 class="text-muted mb-2">الصلاحيات:</h6>
                <div class="d-flex flex-wrap gap-1">
                    @forelse($role->permissions->take(5) as $permission)
                    <span class="badge bg-light text-dark border">{{ $permission->name }}</span>
                    @empty
                    <span class="text-muted">لا توجد صلاحيات</span>
                    @endforelse
                    @if($role->permissions->count() > 5)
                    <span class="badge bg-primary">+{{ $role->permissions->count() - 5 }}</span>
                    @endif
                </div>
            </div>
            <div class="card-footer bg-white border-0">
                <div class="btn-group btn-group-sm w-100">
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-primary">
                        <i class="bi bi-edit me-1"></i>تعديل
                    </a>
                    @if(!in_array($role->name, ['admin', 'user']))
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline confirm-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>حذف
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
