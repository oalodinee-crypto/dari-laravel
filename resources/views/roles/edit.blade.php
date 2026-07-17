@extends('layouts.app')

@section('title', 'تعديل الدور')
@section('page-title', 'تعديل الدور')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">اسم الدور <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" required {{ in_array($role->name, ['admin', 'user']) ? 'readonly' : '' }}>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if(in_array($role->name, ['admin', 'user']))
                        <small class="text-muted">لا يمكن تغيير اسم الأدوار الأساسية</small>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">الصلاحيات</label>
                        <div class="row g-2">
                            @foreach($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" id="perm_{{ $permission->id }}" {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>حفظ التغييرات
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                            <i class="bi bi-times me-2"></i>إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
