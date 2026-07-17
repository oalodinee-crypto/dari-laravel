@extends('layouts.app')

@section('title', $property->title)
@section('page-title', 'تفاصيل العقار')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <!-- Images -->
        <div class="card border-0 shadow-sm mb-4">
            @if($property->images && count($property->images) > 0)
            <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($property->images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" style="height: 400px; object-fit: cover;">
                    </div>
                    @endforeach
                </div>
                @if(count($property->images) > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                @endif
            </div>
            @else
            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                <i class="bi bi-building fa-5x text-muted"></i>
            </div>
            @endif
        </div>
        
        <!-- Details -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h3 class="mb-3">{{ $property->title }}</h3>
                <p class="text-muted mb-4">
                    <i class="bi bi-map-marker-alt me-2"></i>{{ $property->city }} - {{ $property->district }}
                    @if($property->address)<br><small>{{ $property->address }}</small>@endif
                </p>
                
                <div class="row g-3 mb-4">
                    @if($property->bedrooms)
                    <div class="col-auto">
                        <div class="bg-light rounded p-3 text-center">
                            <i class="bi bi-bed fa-lg text-primary mb-2"></i>
                            <div class="fw-bold">{{ $property->bedrooms }}</div>
                            <small class="text-muted">غرف نوم</small>
                        </div>
                    </div>
                    @endif
                    @if($property->bathrooms)
                    <div class="col-auto">
                        <div class="bg-light rounded p-3 text-center">
                            <i class="bi bi-bath fa-lg text-primary mb-2"></i>
                            <div class="fw-bold">{{ $property->bathrooms }}</div>
                            <small class="text-muted">حمامات</small>
                        </div>
                    </div>
                    @endif
                    @if($property->area)
                    <div class="col-auto">
                        <div class="bg-light rounded p-3 text-center">
                            <i class="bi bi-ruler-combined fa-lg text-primary mb-2"></i>
                            <div class="fw-bold">{{ $property->area }}</div>
                            <small class="text-muted">متر مربع</small>
                        </div>
                    </div>
                    @endif
                </div>
                
                <h5>الوصف</h5>
                <p class="text-muted">{{ $property->description ?? 'لا يوجد وصف' }}</p>
                
                @if($property->features && count($property->features) > 0)
                <h5 class="mt-4">المميزات</h5>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($property->features as $feature)
                    <span class="badge bg-light text-dark border">
                        <i class="bi bi-check text-success me-1"></i>{{ $feature }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Price Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center">
                <h2 class="text-primary fw-bold mb-1">{{ number_format($property->price) }}</h2>
                <p class="text-muted mb-3">ريال سعودي</p>
                <span class="badge fs-6 
                    @switch($property->status)
                        @case('available') bg-success @break
                        @case('rented') bg-info @break
                        @case('sold') bg-secondary @break
                        @case('maintenance') bg-warning @break
                    @endswitch
                ">
                    @switch($property->status)
                        @case('available') متاح @break
                        @case('rented') مؤجر @break
                        @case('sold') مباع @break
                        @case('maintenance') صيانة @break
                    @endswitch
                </span>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">الإجراءات</h5>
                <div class="d-grid gap-2">
                    @can('edit properties')
                    <a href="{{ route('properties.edit', $property) }}" class="btn btn-outline-primary">
                        <i class="bi bi-edit me-2"></i>تعديل العقار
                    </a>
                    @endcan
                    <a href="{{ route('maintenance.create') }}?property_id={{ $property->id }}" class="btn btn-outline-warning">
                        <i class="bi bi-tools me-2"></i>طلب صيانة
                    </a>
                    @can('delete properties')
                    <form action="{{ route('properties.destroy', $property) }}" method="POST" class="confirm-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>حذف العقار
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        
        <!-- Owner Info -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">صاحب العقار</h5>
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-user"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ $property->user->name }}</h6>
                        <small class="text-muted">{{ $property->user->email }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('properties.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-right me-2"></i>العودة للقائمة
    </a>
</div>
@endsection
