@extends('layouts.app')

@section('title', 'العقارات')
@section('page-title', 'إدارة العقارات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">قائمة العقارات</h4>
    @can('create properties')
    <a href="{{ route('properties.create') }}" class="btn btn-primary">
        <i class="bi bi-plus me-2"></i>إضافة عقار
    </a>
    @endcan
</div>

<div class="row g-4">
    @forelse($properties as $property)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="position-relative">
                @if($property->images && count($property->images) > 0)
                    <img src="{{ asset('storage/' . $property->images[0]) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $property->title }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-building fa-4x text-muted"></i>
                    </div>
                @endif
                <span class="position-absolute top-0 start-0 m-2 badge 
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
                @if($property->is_featured)
                <span class="position-absolute top-0 end-0 m-2 badge bg-warning">
                    <i class="bi bi-star"></i> مميز
                </span>
                @endif
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ Str::limit($property->title, 35) }}</h5>
                <p class="text-muted mb-2">
                    <i class="bi bi-map-marker-alt me-1"></i>{{ $property->city }} - {{ $property->district }}
                </p>
                <div class="d-flex gap-3 text-muted small mb-3">
                    @if($property->bedrooms)
                    <span><i class="bi bi-bed me-1"></i>{{ $property->bedrooms }} غرف</span>
                    @endif
                    @if($property->bathrooms)
                    <span><i class="bi bi-bath me-1"></i>{{ $property->bathrooms }} حمام</span>
                    @endif
                    @if($property->area)
                    <span><i class="bi bi-ruler-combined me-1"></i>{{ $property->area }} م²</span>
                    @endif
                </div>
                <h5 class="text-primary fw-bold mb-0">{{ number_format($property->price) }} ر.س</h5>
            </div>
            <div class="card-footer bg-white border-0 pt-0">
                <a href="{{ route('properties.show', $property) }}" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-eye me-1"></i>عرض التفاصيل
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="bi bi-building fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">لا توجد عقارات حالياً</h5>
            @can('create properties')
            <a href="{{ route('properties.create') }}" class="btn btn-primary mt-2">
                <i class="bi bi-plus me-2"></i>إضافة أول عقار
            </a>
            @endcan
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $properties->links() }}
</div>
@endsection
