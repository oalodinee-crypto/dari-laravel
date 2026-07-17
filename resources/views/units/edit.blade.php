@extends('layouts.app')

@section('title', 'تعديل وحدة')

@section('content')
<div class="card p-4">
    <h5 class="mb-4"><i class="bi bi-door-open me-2"></i> تعديل وحدة: {{ $unit->unit_number }}</h5>
    
    <form action="{{ route('units.update', $unit) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">رقم الوحدة</label>
                <input type="text" name="unit_number" class="form-control" value="{{ old('unit_number', $unit->unit_number) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">المبنى</label>
                <select name="building_id" class="form-select" required>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}" {{ $unit->building_id == $building->id ? 'selected' : '' }}>{{ $building->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الطابق</label>
                <input type="number" name="floor_number" class="form-control" value="{{ old('floor_number', $unit->floor_number) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">النوع</label>
                <select name="type" class="form-select">
                    <option value="apartment" {{ $unit->type == 'apartment' ? 'selected' : '' }}>شقة</option>
                    <option value="studio" {{ $unit->type == 'studio' ? 'selected' : '' }}>استوديو</option>
                    <option value="villa" {{ $unit->type == 'villa' ? 'selected' : '' }}>فيلا</option>
                    <option value="office" {{ $unit->type == 'office' ? 'selected' : '' }}>مكتب</option>
                    <option value="shop" {{ $unit->type == 'shop' ? 'selected' : '' }}>محل</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select" required>
                    <option value="available" {{ $unit->status == 'available' ? 'selected' : '' }}>شاغرة</option>
                    <option value="occupied" {{ $unit->status == 'occupied' ? 'selected' : '' }}>مؤجرة</option>
                    <option value="maintenance" {{ $unit->status == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">الإيجار الشهري</label>
                <input type="number" name="rent_amount" class="form-control" value="{{ old('rent_amount', $unit->rent_amount) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">المساحة (م²)</label>
                <input type="number" name="area" class="form-control" value="{{ old('area', $unit->area) }}">
            </div>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                <a href="{{ route('units.index') }}" class="btn btn-secondary">إلغاء</a>
            </div>
        </div>
    </form>
</div>
@endsection
