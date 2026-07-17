@extends('layouts.app')
@section('title', 'تقرير الإشغال')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4"><i class="bi bi-pie-chart me-2"></i>تقرير الإشغال</h1>
    <div class="row">
        @foreach($buildings as $building)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">{{ $building->name }}</h5></div>
                <div class="card-body">
                    @php
                        $total = $building->units->count();
                        $occupied = $building->units->where('status', 'occupied')->count();
                        $rate = $total > 0 ? round(($occupied / $total) * 100) : 0;
                    @endphp
                    <div class="d-flex justify-content-between mb-2"><span>الإجمالي</span><span class="badge bg-primary">{{ $total }}</span></div>
                    <div class="d-flex justify-content-between mb-2"><span>مؤجرة</span><span class="badge bg-success">{{ $occupied }}</span></div>
                    <div class="d-flex justify-content-between mb-2"><span>متاحة</span><span class="badge bg-info">{{ $total - $occupied }}</span></div>
                    <hr>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" style="width: {{ $rate }}%">{{ $rate }}%</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
