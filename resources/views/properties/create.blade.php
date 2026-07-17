@extends('layouts.app')

@section('title', 'إضافة عقار')
@section('page-title', 'إضافة عقار جديد')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">عنوان العقار <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">نوع العقار <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="apartment" {{ old('type') == 'apartment' ? 'selected' : '' }}>شقة</option>
                            <option value="villa" {{ old('type') == 'villa' ? 'selected' : '' }}>فيلا</option>
                            <option value="office" {{ old('type') == 'office' ? 'selected' : '' }}>مكتب</option>
                            <option value="land" {{ old('type') == 'land' ? 'selected' : '' }}>أرض</option>
                            <option value="building" {{ old('type') == 'building' ? 'selected' : '' }}>مبنى</option>
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">الوصف</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">السعر (ر.س) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">المساحة (م²)</label>
                        <input type="number" name="area" class="form-control" value="{{ old('area') }}">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>متاح</option>
                            <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>مؤجر</option>
                            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>مباع</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">عدد الغرف</label>
                        <input type="number" name="bedrooms" class="form-control" value="{{ old('bedrooms') }}" min="0">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">عدد الحمامات</label>
                        <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms') }}" min="0">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">المدينة <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">الحي</label>
                        <input type="text" name="district" class="form-control" value="{{ old('district') }}">
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">العنوان التفصيلي</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">صور العقار</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="text-muted">يمكنك اختيار عدة صور</small>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>حفظ العقار
                </button>
                <a href="{{ route('properties.index') }}" class="btn btn-secondary">
                    <i class="bi bi-times me-2"></i>إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
