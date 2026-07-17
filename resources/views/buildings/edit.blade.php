@extends('layouts.app')

@section('title', 'تعديل مبنى')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="bi bi-building me-2"></i>تعديل مبنى: {{ $building->name }}</h1>
        <a href="{{ route('buildings.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-right me-1"></i>رجوع
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('buildings.update', $building) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">اسم المبنى <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $building->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الكود <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                               value="{{ old('code', $building->code) }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">المدينة <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                               value="{{ old('city', $building->city) }}" required>
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الحي</label>
                        <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" 
                               value="{{ old('district', $building->district) }}">
                        @error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">عدد الطوابق <span class="text-danger">*</span></label>
                        <input type="number" name="floors_count" class="form-control @error('floors_count') is-invalid @enderror" 
                               value="{{ old('floors_count', $building->floors_count) }}" min="1" required>
                        @error('floors_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">العنوان <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                               value="{{ old('address', $building->address) }}" required>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">سنة البناء</label>
                        <input type="number" name="year_built" class="form-control @error('year_built') is-invalid @enderror" 
                               value="{{ old('year_built', $building->year_built) }}" min="1900" max="{{ date('Y') }}">
                        @error('year_built')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">المساحة الإجمالية (م²)</label>
                        <input type="number" name="total_area" class="form-control @error('total_area') is-invalid @enderror" 
                               value="{{ old('total_area', $building->total_area) }}" step="0.01">
                        @error('total_area')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الحالة <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', $building->status) == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="maintenance" {{ old('status', $building->status) == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                            <option value="inactive" {{ old('status', $building->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">المدير</label>
                        <select name="manager_id" class="form-select @error('manager_id') is-invalid @enderror">
                            <option value="">-- اختر المدير --</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ old('manager_id', $building->manager_id) == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('manager_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تصنيف المبنى</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" id="categorySelect">
                            <option value="">اختر التصنيف</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $building->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">نوع المبنى</label>
                        <select name="type_id" class="form-select @error('type_id') is-invalid @enderror" id="typeSelect">
                            <option value="">اختر النوع</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}" data-category="{{ $type->category_id }}" 
                                    {{ old('type_id', $building->type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description', $building->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check me-1"></i>حفظ التغييرات
                        </button>
                        <a href="{{ route('buildings.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('categorySelect').addEventListener('change', function() {
    const categoryId = this.value;
    const typeSelect = document.getElementById('typeSelect');
    const options = typeSelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = '';
        } else if (categoryId === '' || option.dataset.category === categoryId) {
            option.style.display = '';
        } else {
            option.style.display = 'none';
        }
    });
    
    typeSelect.value = '';
});
</script>
@endpush