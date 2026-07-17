@extends('layouts.app')

@section('title', 'إضافة مبنى')
@section('page-title', 'إضافة مبنى جديد')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('buildings.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">اسم المبنى <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">الكود <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required placeholder="مثال: BLD001">
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- نوع المبنى - قائمة شاملة -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">نوع المبنى <span class="text-danger">*</span></label>
                            <select name="building_type" class="form-select @error('building_type') is-invalid @enderror" required>
                                <option value="">اختر نوع المبنى</option>
                                <optgroup label="سكني">
                                    <option value="عمارة سكنية" {{ old('building_type') == 'عمارة سكنية' ? 'selected' : '' }}>عمارة سكنية</option>
                                    <option value="برج سكني" {{ old('building_type') == 'برج سكني' ? 'selected' : '' }}>برج سكني</option>
                                    <option value="مجمع سكني" {{ old('building_type') == 'مجمع سكني' ? 'selected' : '' }}>مجمع سكني</option>
                                    <option value="فيلا" {{ old('building_type') == 'فيلا' ? 'selected' : '' }}>فيلا</option>
                                    <option value="دوبلكس" {{ old('building_type') == 'دوبلكس' ? 'selected' : '' }}>دوبلكس</option>
                                    <option value="شقق مفروشة" {{ old('building_type') == 'شقق مفروشة' ? 'selected' : '' }}>شقق مفروشة</option>
                                    <option value="استوديو" {{ old('building_type') == 'استوديو' ? 'selected' : '' }}>استوديو</option>
                                    <option value="سكن عمال" {{ old('building_type') == 'سكن عمال' ? 'selected' : '' }}>سكن عمال</option>
                                    <option value="سكن طلاب" {{ old('building_type') == 'سكن طلاب' ? 'selected' : '' }}>سكن طلاب</option>
                                </optgroup>
                                <optgroup label="تجاري">
                                    <option value="شركة" {{ old('building_type') == 'شركة' ? 'selected' : '' }}>شركة</option>
                                    <option value="مؤسسة" {{ old('building_type') == 'مؤسسة' ? 'selected' : '' }}>مؤسسة</option>
                                    <option value="برج مكاتب" {{ old('building_type') == 'برج مكاتب' ? 'selected' : '' }}>برج مكاتب</option>
                                    <option value="مجمع تجاري" {{ old('building_type') == 'مجمع تجاري' ? 'selected' : '' }}>مجمع تجاري</option>
                                    <option value="معرض" {{ old('building_type') == 'معرض' ? 'selected' : '' }}>معرض</option>
                                    <option value="مستودع" {{ old('building_type') == 'مستودع' ? 'selected' : '' }}>مستودع</option>
                                </optgroup>
                                <optgroup label="فندقي">
                                    <option value="فندق" {{ old('building_type') == 'فندق' ? 'selected' : '' }}>فندق</option>
                                    <option value="شقق فندقية" {{ old('building_type') == 'شقق فندقية' ? 'selected' : '' }}>شقق فندقية</option>
                                    <option value="نُزل" {{ old('building_type') == 'نُزل' ? 'selected' : '' }}>نُزل</option>
                                    <option value="منتجع" {{ old('building_type') == 'منتجع' ? 'selected' : '' }}>منتجع</option>
                                </optgroup>
                                <optgroup label="مختلط">
                                    <option value="برج سكني تجاري" {{ old('building_type') == 'برج سكني تجاري' ? 'selected' : '' }}>برج سكني تجاري</option>
                                    <option value="مجمع متعدد الاستخدام" {{ old('building_type') == 'مجمع متعدد الاستخدام' ? 'selected' : '' }}>مجمع متعدد الاستخدام</option>
                                </optgroup>
                            </select>
                            @error('building_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الحالة <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">الوصف</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">العنوان <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address') }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">المدينة <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" required>
                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">الحي</label>
                            <input type="text" name="district" class="form-control" value="{{ old('district') }}">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">عدد الطوابق <span class="text-danger">*</span></label>
                            <input type="number" name="floors_count" class="form-control" value="{{ old('floors_count', 1) }}" min="1" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">سنة البناء</label>
                            <input type="number" name="year_built" class="form-control" value="{{ old('year_built') }}" min="1900" max="{{ date('Y') }}">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">المساحة الإجمالية (م²)</label>
                            <input type="number" name="total_area" class="form-control" value="{{ old('total_area') }}" step="0.01">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">مدير المبنى</label>
                            <select name="manager_id" class="form-select">
                                <option value="">بدون مدير</option>
                                @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>حفظ المبنى
                        </button>
                        <a href="{{ route('buildings.index') }}" class="btn btn-secondary">
                            <i class="bi bi-times me-2"></i>إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection