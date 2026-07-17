@extends('layouts.app')

@section('title', 'تعديل العقار')
@section('page-title', 'تعديل العقار')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">عنوان العقار <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $property->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">نوع العقار <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="apartment" {{ old('type', $property->type) == 'apartment' ? 'selected' : '' }}>شقة</option>
                            <option value="villa" {{ old('type', $property->type) == 'villa' ? 'selected' : '' }}>فيلا</option>
                            <option value="office" {{ old('type', $property->type) == 'office' ? 'selected' : '' }}>مكتب</option>
                            <option value="land" {{ old('type', $property->type) == 'land' ? 'selected' : '' }}>أرض</option>
                            <option value="building" {{ old('type', $property->type) == 'building' ? 'selected' : '' }}>مبنى</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">الوصف</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $property->description) }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">السعر (ر.س) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $property->price) }}" required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">المساحة (م²)</label>
                        <input type="number" name="area" class="form-control" value="{{ old('area', $property->area) }}">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="available" {{ old('status', $property->status) == 'available' ? 'selected' : '' }}>متاح</option>
                            <option value="rented" {{ old('status', $property->status) == 'rented' ? 'selected' : '' }}>مؤجر</option>
                            <option value="sold" {{ old('status', $property->status) == 'sold' ? 'selected' : '' }}>مباع</option>
                            <option value="maintenance" {{ old('status', $property->status) == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">عدد الغرف</label>
                        <input type="number" name="bedrooms" class="form-control" value="{{ old('bedrooms', $property->bedrooms) }}" min="0">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">عدد الحمامات</label>
                        <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms', $property->bathrooms) }}" min="0">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">المدينة <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $property->city) }}" required>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">الحي</label>
                        <input type="text" name="district" class="form-control" value="{{ old('district', $property->district) }}">
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">إضافة صور جديدة</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>حفظ التغييرات
                </button>
                <a href="{{ route('properties.show', $property) }}" class="btn btn-secondary">
                    <i class="bi bi-times me-2"></i>إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
