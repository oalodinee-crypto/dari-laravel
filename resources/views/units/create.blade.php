@extends('layouts.app')

@section('title', 'إضافة وحدة جديدة')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-plus-circle text-primary me-2"></i>
                    إضافة وحدة جديدة
                </h2>
                <a href="{{ route('units.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-1"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-door-open me-2"></i>
                        بيانات الوحدة
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('units.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="building_id" class="form-label">المبنى <span class="text-danger">*</span></label>
                                <select class="form-select @error('building_id') is-invalid @enderror" id="building_id" name="building_id" required>
                                    <option value="">-- اختر المبنى --</option>
                                    @foreach($buildings as $building)
                                        <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                            {{ $building->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('building_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="unit_number" class="form-label">رقم الوحدة <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('unit_number') is-invalid @enderror" 
                                       id="unit_number" name="unit_number" value="{{ old('unit_number') }}" required>
                                @error('unit_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="floor" class="form-label">الطابق <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('floor') is-invalid @enderror" 
                                       id="floor" name="floor" value="{{ old('floor') }}" min="0" required>
                                @error('floor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">نوع الوحدة <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">-- اختر النوع --</option>
                                    <option value="apartment" {{ old('type') == 'apartment' ? 'selected' : '' }}>شقة سكنية</option>
                                    <option value="office" {{ old('type') == 'office' ? 'selected' : '' }}>مكتب</option>
                                    <option value="shop" {{ old('type') == 'shop' ? 'selected' : '' }}>محل تجاري</option>
                                    <option value="warehouse" {{ old('type') == 'warehouse' ? 'selected' : '' }}>مستودع</option>
                                    <option value="studio" {{ old('type') == 'studio' ? 'selected' : '' }}>استوديو</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="area" class="form-label">المساحة (م²)</label>
                                <input type="number" class="form-control @error('area') is-invalid @enderror" 
                                       id="area" name="area" value="{{ old('area') }}" step="0.01" min="0">
                                @error('area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="rent_amount" class="form-label">مبلغ الإيجار <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('rent_amount') is-invalid @enderror" 
                                           id="rent_amount" name="rent_amount" value="{{ old('rent_amount') }}" step="0.01" min="0" required>
                                    <span class="input-group-text">ر.س</span>
                                </div>
                                @error('rent_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bedrooms" class="form-label">عدد غرف النوم</label>
                                <input type="number" class="form-control @error('bedrooms') is-invalid @enderror" 
                                       id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" min="0">
                                @error('bedrooms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="bathrooms" class="form-label">عدد دورات المياه</label>
                                <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" 
                                       id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" min="0">
                                @error('bathrooms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">الحالة</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>متاحة</option>
                                    <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>مؤجرة</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>تحت الصيانة</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">وصف الوحدة</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                حفظ الوحدة
                            </button>
                            <a href="{{ route('units.index') }}" class="btn btn-secondary">
                                <i class="bi bi-times me-1"></i>
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        ملاحظات
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            الحقول المميزة بـ <span class="text-danger">*</span> إلزامية
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            اختر المبنى التابعة له الوحدة
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            حدد نوع الوحدة بدقة
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-2"></i>
                            مبلغ الإيجار بالريال السعودي
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
