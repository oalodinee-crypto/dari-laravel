@extends('layouts.app')
@section('title', 'صلاحيات المستخدم')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3"><i class="bi bi-shield-lock me-2"></i>صلاحيات: {{ $user->name }}</h1>
        <a href="{{ route('users.show', $user) }}" class="btn btn-secondary"><i class="bi bi-arrow-right me-1"></i>رجوع</a>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.permissions.update', $user) }}" method="POST">
                @csrf
                <div class="row">
                    @foreach($permissions as $permission)
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check me-1"></i>حفظ</button>
            </form>
        </div>
    </div>
</div>
@endsection
