@extends('layouts.app')

@section('title', 'طلب وحدة')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header"><h5 class="mb-0"><i class="bi bi-house-add me-2"></i>طلب وحدة جديدة</h5></div>
                <div class="card-body">
                    <form action="{{ route('resident.request-unit.store') }}" method="POST">
                        @csrf
                        
                        <!-- نوع الوحدة والمبنى -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">نوع الوحدة *</label>
                                <select name="unit_type" class="form-select" required>
                                    <option value="">اختر</option>
                                    <option value="شقة">شقة</option>
                                    <option value="استوديو">استوديو</option>
                                    <option value="فيلا">فيلا</option>
                                    <option value="مكتب">مكتب</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">المبنى المفضل</label>
                                <select name="building_id" class="form-select">
                                    <option value="">أي مبنى</option>
                                    @foreach($buildings as $building)
                                        <option value="{{ $building->id }}">{{ $building->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- عدد الغرف والحمامات والمساحة -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">عدد الغرف</label>
                                <input type="number" name="rooms_count" class="form-control" min="1" max="20">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">عدد الحمامات</label>
                                <input type="number" name="bathrooms_count" class="form-control" min="1" max="10">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">المساحة المطلوبة (م²)</label>
                                <input type="number" name="area_required" class="form-control" min="1" placeholder="مثال: 150">
                            </div>
                        </div>

                        <!-- الطابق المفضل -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الطابق المفضل (من)</label>
                                <input type="number" name="floor_from" class="form-control" min="0" placeholder="مثال: 1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الطابق المفضل (إلى)</label>
                                <input type="number" name="floor_to" class="form-control" min="0" placeholder="مثال: 5">
                            </div>
                        </div>

                        <!-- الميزانية -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الميزانية من</label>
                                <input type="number" name="budget_min" class="form-control" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الميزانية إلى</label>
                                <input type="number" name="budget_max" class="form-control" min="0">
                            </div>
                        </div>

                        <!-- خيارات إضافية -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">موقف سيارة</label>
                                <select name="parking" class="form-select">
                                    <option value="">لا يهم</option>
                                    <option value="نعم">نعم</option>
                                    <option value="لا">لا</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">مفروشة</label>
                                <select name="furnished" class="form-select">
                                    <option value="">لا يهم</option>
                                    <option value="نعم">نعم</option>
                                    <option value="لا">لا</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">الإطلالة المفضلة</label>
                                <select name="view_preference" class="form-select">
                                    <option value="">لا يهم</option>
                                    <option value="شارع">شارع</option>
                                    <option value="حديقة">حديقة</option>
                                    <option value="بحر">بحر</option>
                                </select>
                            </div>
                        </div>

                        <!-- تاريخ الانتقال ورقم الهاتف -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ الانتقال المتوقع</label>
                                <input type="date" name="move_date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم الهاتف للتواصل</label>
                                <input type="text" name="contact_phone" class="form-control" placeholder="مثال: 0501234567">
                            </div>
                        </div>

                        <!-- ملاحظات -->
                        <div class="mb-3">
                            <label class="form-label">ملاحظات إضافية</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="أي متطلبات أو تفاصيل إضافية..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-send me-2"></i>إرسال الطلب</button>
                        <a href="{{ route('resident.my-requests') }}" class="btn btn-secondary">رجوع</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
