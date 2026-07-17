@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="card p-4">
    <h5 class="mb-4"><i class="bi bi-person-circle me-2"></i> الملف الشخصي</h5>
    
    <div class="text-center mb-4">
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle" style="width:100px;height:100px;object-fit:cover;">
        @else
            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:100px;height:100px;font-size:2.5rem;">
                {{ mb_substr($user->name ?? 'م', 0, 1) }}
            </div>
        @endif
        <h4 class="mt-3 mb-0">{{ $user->name }}</h4>
        <p class="text-muted">{{ $user->roles->first()->name ?? '-' }}</p>
    </div>
    
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">البريد</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">الدور</label>
                <input type="text" class="form-control" value="{{ $user->roles->first()->name ?? '-' }}" disabled>
            </div>
            
            <div class="col-12">
                <label class="form-label">الصورة الشخصية</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
            </div>
            
            <div class="col-12"><hr><h6>تغيير كلمة المرور (اختياري)</h6></div>
            
            <div class="col-md-6">
                <label class="form-label">كلمة المرور الجديدة</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
            </div>
        </div>
    </form>
</div>
@endsection
