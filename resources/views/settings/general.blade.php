@extends('layouts.app')
@section('title', 'الإعدادات العامة')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4"><i class="bi bi-gear me-2"></i>الإعدادات العامة</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">اسم النظام</label><input type="text" name="app_name" class="form-control" value="{{ $settings['app_name'] ?? 'داري' }}"></div>
                    <div class="col-md-6"><label class="form-label">البريد الإلكتروني</label><input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}"></div>
                    <div class="col-md-6"><label class="form-label">الهاتف</label><input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}"></div>
                    <div class="col-md-6"><label class="form-label">العنوان</label><input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}"></div>
                </div>
                <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-check me-1"></i>حفظ</button>
            </form>
        </div>
    </div>
</div>
@endsection
