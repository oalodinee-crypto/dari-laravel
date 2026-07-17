@extends('layouts.app')
@section('title', 'التقرير المالي')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4"><i class="bi bi-graph-up me-2"></i>التقرير المالي</h1>
    <div class="row mb-4">
        <div class="col-md-4"><div class="card bg-success text-white"><div class="card-body"><h4>{{ number_format($data['total_income'] ?? 0) }} ر.س</h4><p class="mb-0">إجمالي الإيرادات</p></div></div></div>
        <div class="col-md-4"><div class="card bg-warning text-white"><div class="card-body"><h4>{{ number_format($data['pending'] ?? 0) }} ر.س</h4><p class="mb-0">مستحقات معلقة</p></div></div></div>
        <div class="col-md-4"><div class="card bg-info text-white"><div class="card-body"><h4>{{ $data['contracts_count'] ?? 0 }}</h4><p class="mb-0">العقود النشطة</p></div></div></div>
    </div>
    <div class="card">
        <div class="card-header"><h5 class="mb-0">الإيرادات الشهرية</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table"><thead><tr><th>الشهر</th><th>الإيرادات</th></tr></thead>
                <tbody>@foreach($monthlyData ?? [] as $month)<tr><td>{{ $month['month'] }}</td><td>{{ number_format($month['amount']) }} ر.س</td></tr>@endforeach</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
