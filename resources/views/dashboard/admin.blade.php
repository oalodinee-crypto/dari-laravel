@extends('layouts.app')

@section('title', 'لوحة التحكم - الإدارة')
@section('page-title', 'لوحة التحكم')

@push('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .stat-card .icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .chart-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .chart-card .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1rem 1.25rem;
    }
    .chart-card .card-body {
        padding: 1rem;
    }
    .progress-stat {
        height: 8px;
        border-radius: 4px;
        background: #e9ecef;
    }
    .alert-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .table-modern {
        border-radius: 12px;
        overflow: hidden;
    }
    .table-modern thead {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    .table-modern tbody tr:hover {
        background: #f8f9fa;
    }
    .gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .gradient-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .gradient-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .gradient-danger { background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); }
    .gradient-dark { background: linear-gradient(135deg, #232526 0%, #414345 100%); }
    a.text-decoration-none .stat-card {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<!-- ═══════════════════════════════════════════════════════════ -->
<!-- 📊 STATS CARDS ROW 1 -->
<!-- ═══════════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('payments.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">إجمالي الإيرادات</p>
                        <h3 class="mb-0 fw-bold text-dark">{{ number_format($stats['total_revenue']) }}</h3>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> ر.س</small>
                    </div>
                    <div class="icon gradient-primary text-white">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('payments.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">إيرادات الشهر</p>
                        <h3 class="mb-0 fw-bold text-dark">{{ number_format($stats['monthly_revenue']) }}</h3>
                        <small class="text-muted">ر.س</small>
                    </div>
                    <div class="icon gradient-success text-white">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('units.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">نسبة الإشغال</p>
                        <h3 class="mb-0 fw-bold text-dark">{{ $stats['occupancy_rate'] }}%</h3>
                        <div class="progress progress-stat mt-2" style="width: 100px;">
                            <div class="progress-bar bg-info" style="width: {{ $stats['occupancy_rate'] }}%"></div>
                        </div>
                    </div>
                    <div class="icon gradient-info text-white">
                        <i class="bi bi-house-check"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('contracts.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">العقود النشطة</p>
                        <h3 class="mb-0 fw-bold text-dark">{{ $stats['active_contracts'] }}</h3>
                        <small class="text-warning">{{ $stats['expiring_contracts'] }} تنتهي قريباً</small>
                    </div>
                    <div class="icon gradient-warning text-white">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════ -->
<!-- 📊 STATS CARDS ROW 2 -->
<!-- ═══════════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('buildings.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">إجمالي المباني</p>
                        <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_buildings'] }}</h3>
                        <small class="text-primary">{{ $stats['total_units'] }} وحدة</small>
                    </div>
                    <div class="icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('maintenance.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">طلبات الصيانة</p>
                        <h3 class="mb-0 fw-bold text-warning">{{ $stats['pending_maintenance'] }}</h3>
                        <small class="text-info">{{ $stats['in_progress_maintenance'] }} قيد التنفيذ</small>
                    </div>
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-tools"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('invoices.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">فواتير متأخرة</p>
                        <h3 class="mb-0 fw-bold text-danger">{{ $stats['overdue_invoices'] }}</h3>
                        <small class="text-danger">{{ number_format($stats['overdue_amount']) }} ر.س</small>
                    </div>
                    <div class="icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-6 col-xl-3">
        <a href="{{ route('users.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">المستخدمين</p>
                        <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_users'] }}</h3>
                        <small class="text-success">+{{ $stats['new_users_month'] }} هذا الشهر</small>
                    </div>
                    <div class="icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════ -->
<!-- 📈 CHARTS ROW 1 -->
<!-- ═══════════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <!-- Chart 1: Monthly Revenue -->
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-graph-up text-primary me-2"></i>الإيرادات الشهرية</h6>
                <span class="badge bg-primary">{{ now()->year }}</span>
            </div>
            <div class="card-body">
                <div id="chart-monthly-revenue" style="height: 350px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Chart 11: Collection Rate Gauge -->
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-speedometer2 text-success me-2"></i>أداء التحصيل</h6>
            </div>
            <div class="card-body">
                <div id="chart-collection-rate" style="height: 350px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════ -->
<!-- 📊 CHARTS ROW 2 -->
<!-- ═══════════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <!-- Chart 2: Revenue vs Expenses -->
    <div class="col-lg-6">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-bar-chart text-info me-2"></i>الإيرادات مقابل المصروفات</h6>
            </div>
            <div class="card-body">
                <div id="chart-revenue-expenses" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Chart 6: Maintenance Trend -->
    <div class="col-lg-6">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-tools text-warning me-2"></i>طلبات الصيانة الشهرية</h6>
            </div>
            <div class="card-body">
                <div id="chart-maintenance-trend" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════ -->
<!-- 🎯 CHARTS ROW 3 -->
<!-- ═══════════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <!-- Chart 3: Units by Status -->
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-house text-primary me-2"></i>حالة الوحدات</h6>
            </div>
            <div class="card-body">
                <div id="chart-units-status" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Chart 4: Contracts by Status -->
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-file-text text-success me-2"></i>حالة العقود</h6>
            </div>
            <div class="card-body">
                <div id="chart-contracts-status" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Chart 5: Invoices by Status -->
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-receipt text-danger me-2"></i>حالة الفواتير</h6>
            </div>
            <div class="card-body">
                <div id="chart-invoices-status" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════ -->
<!-- 📊 CHARTS ROW 4 -->
<!-- ═══════════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <!-- Chart 7: Users Trend -->
    <div class="col-lg-6">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-people text-info me-2"></i>المستخدمين الجدد</h6>
            </div>
            <div class="card-body">
                <div id="chart-users-trend" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Chart 12: Complaints Analysis -->
    <div class="col-lg-6">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-chat-dots text-danger me-2"></i>تحليل الشكاوى</h6>
            </div>
            <div class="card-body">
                <div id="chart-complaints" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════ -->
<!-- 📊 CHARTS ROW 5 -->
<!-- ═══════════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <!-- Chart 8: Units per Building -->
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-building text-primary me-2"></i>الوحدات لكل مبنى</h6>
            </div>
            <div class="card-body">
                <div id="chart-units-building" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Chart 9: Payment Methods -->
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-credit-card text-success me-2"></i>طرق الدفع</h6>
            </div>
            <div class="card-body">
                <div id="chart-payment-methods" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Chart 10: Weekly Heatmap -->
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="bi bi-calendar3 text-warning me-2"></i>نشاط الدفع الأسبوعي</h6>
            </div>
            <div class="card-body">
                <div id="chart-weekly-heatmap" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════ -->
<!-- 🚨 ALERTS & TABLES -->
<!-- ═══════════════════════════════════════════════════════════ -->
<div class="row g-4 mb-4">
    <!-- Expiring Contracts Alert -->
    <div class="col-lg-6">
        <div class="card alert-card border-warning">
            <div class="card-header bg-warning bg-opacity-10 border-0">
                <h6 class="mb-0 fw-bold text-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    عقود تنتهي قريباً ({{ count($expiringContracts) }})
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>المستأجر</th>
                                <th>الوحدة</th>
                                <th>تاريخ الانتهاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expiringContracts->take(5) as $contract)
                            <tr>
                                <td>{{ $contract->tenant->name ?? '-' }}</td>
                                <td>{{ $contract->unit->unit_number ?? '-' }}</td>
                                <td><span class="badge bg-warning">{{ $contract->end_date }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">لا توجد عقود تنتهي قريباً</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Payments -->
    <div class="col-lg-6">
        <div class="card alert-card border-success">
            <div class="card-header bg-success bg-opacity-10 border-0">
                <h6 class="mb-0 fw-bold text-success">
                    <i class="bi bi-cash-stack me-2"></i>
                    آخر المدفوعات
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الدفعة</th>
                                <th>المبلغ</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayments as $payment)
                            <tr>
                                <td>{{ $payment->payment_number ?? '#' . $payment->id }}</td>
                                <td class="fw-bold text-success">{{ number_format($payment->amount) }} ر.س</td>
                                <td>{{ $payment->created_at->format('Y/m/d') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">لا توجد مدفوعات</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row g-4">
    <div class="col-12">
        <div class="card alert-card">
            <div class="card-header bg-white border-0">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-activity me-2 text-primary"></i>
                    آخر النشاطات
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($recentActivities as $activity)
                    <div class="col-md-6 mb-2">
                        <div class="d-flex align-items-center p-2 bg-light rounded">
                            <div class="me-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="bi bi-clock text-primary"></i>
                                </div>
                            </div>
                            <div>
                                <p class="mb-0 small">{{ $activity->description ?? 'نشاط' }}</p>
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-3">لا توجد نشاطات حديثة</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
    const chartsData = @json($chartsData);
    
    // Chart 1: Monthly Revenue (Line Chart)
    new ApexCharts(document.querySelector("#chart-monthly-revenue"), {
        series: [{
            name: 'الإيرادات',
            data: chartsData.monthlyRevenue
        }],
        chart: { type: 'area', height: 350, toolbar: { show: false }, fontFamily: 'inherit' },
        colors: ['#667eea'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.2 }},
        stroke: { curve: 'smooth', width: 3 },
        xaxis: { categories: months },
        yaxis: { labels: { formatter: v => v.toLocaleString() + ' ر.س' }},
        tooltip: { y: { formatter: v => v.toLocaleString() + ' ر.س' }}
    }).render();
    
    // Chart 11: Collection Rate (Radial)
    new ApexCharts(document.querySelector("#chart-collection-rate"), {
        series: [chartsData.collectionRate],
        chart: { type: 'radialBar', height: 350 },
        colors: ['#11998e'],
        plotOptions: {
            radialBar: {
                hollow: { size: '70%' },
                dataLabels: {
                    name: { show: true, fontSize: '16px', color: '#888' },
                    value: { show: true, fontSize: '32px', fontWeight: 'bold', formatter: v => v + '%' }
                }
            }
        },
        labels: ['نسبة التحصيل']
    }).render();
    
    // Chart 2: Revenue vs Expenses (Bar Chart)
    new ApexCharts(document.querySelector("#chart-revenue-expenses"), {
        series: [
            { name: 'الإيرادات', data: chartsData.revenueVsExpenses.revenue },
            { name: 'المصروفات', data: chartsData.revenueVsExpenses.expenses }
        ],
        chart: { type: 'bar', height: 300, toolbar: { show: false }},
        colors: ['#11998e', '#ff416c'],
        plotOptions: { bar: { borderRadius: 4, columnWidth: '60%' }},
        xaxis: { categories: months },
        legend: { position: 'top' }
    }).render();
    
    // Chart 6: Maintenance Trend (Area Chart)
    new ApexCharts(document.querySelector("#chart-maintenance-trend"), {
        series: [{ name: 'طلبات الصيانة', data: chartsData.maintenanceTrend }],
        chart: { type: 'area', height: 300, toolbar: { show: false }},
        colors: ['#f5576c'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1 }},
        stroke: { curve: 'smooth', width: 2 },
        xaxis: { categories: months }
    }).render();
    
    // Chart 3: Units by Status (Donut Chart)
    const unitsLabels = { 'available': 'متاحة', 'occupied': 'مشغولة', 'maintenance': 'صيانة', 'reserved': 'محجوزة' };
    new ApexCharts(document.querySelector("#chart-units-status"), {
        series: Object.values(chartsData.unitsByStatus),
        chart: { type: 'donut', height: 280 },
        colors: ['#38ef7d', '#667eea', '#f5576c', '#ffd93d'],
        labels: Object.keys(chartsData.unitsByStatus).map(k => unitsLabels[k] || k),
        legend: { position: 'bottom' }
    }).render();
    
    // Chart 4: Contracts by Status (Pie Chart)
    const contractLabels = { 'active': 'نشط', 'expired': 'منتهي', 'cancelled': 'ملغي', 'pending': 'معلق' };
    new ApexCharts(document.querySelector("#chart-contracts-status"), {
        series: Object.values(chartsData.contractsByStatus),
        chart: { type: 'pie', height: 280 },
        colors: ['#11998e', '#ff6b6b', '#feca57', '#667eea'],
        labels: Object.keys(chartsData.contractsByStatus).map(k => contractLabels[k] || k),
        legend: { position: 'bottom' }
    }).render();
    
    // Chart 5: Invoices by Status
    const invoiceLabels = { 'pending': 'معلقة', 'paid': 'مدفوعة', 'overdue': 'متأخرة', 'cancelled': 'ملغاة' };
    new ApexCharts(document.querySelector("#chart-invoices-status"), {
        series: Object.values(chartsData.invoicesByStatus),
        chart: { type: 'donut', height: 280 },
        colors: ['#feca57', '#38ef7d', '#ff6b6b', '#a5b1c2'],
        labels: Object.keys(chartsData.invoicesByStatus).map(k => invoiceLabels[k] || k),
        legend: { position: 'bottom' }
    }).render();
    
    // Chart 7: Users Trend
    new ApexCharts(document.querySelector("#chart-users-trend"), {
        series: [{ name: 'المستخدمين الجدد', data: chartsData.usersTrend }],
        chart: { type: 'line', height: 280, toolbar: { show: false }},
        colors: ['#4facfe'],
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 5 },
        xaxis: { categories: months }
    }).render();
    
    // Chart 12: Complaints Analysis
    new ApexCharts(document.querySelector("#chart-complaints"), {
        series: [
            { name: 'إجمالي الشكاوى', type: 'column', data: chartsData.complaintsTrend },
            { name: 'تم حلها', type: 'line', data: chartsData.complaintsResolved }
        ],
        chart: { height: 280, toolbar: { show: false }},
        colors: ['#ff6b6b', '#38ef7d'],
        stroke: { width: [0, 3] },
        xaxis: { categories: months }
    }).render();
    
    // Chart 8: Units per Building
    const buildingNames = chartsData.unitsPerBuilding.map(b => b.name);
    const buildingCounts = chartsData.unitsPerBuilding.map(b => b.count);
    new ApexCharts(document.querySelector("#chart-units-building"), {
        series: buildingCounts,
        chart: { type: 'polarArea', height: 280 },
        labels: buildingNames,
        colors: ['#667eea', '#f093fb', '#4facfe', '#38ef7d', '#feca57', '#ff6b6b'],
        legend: { position: 'bottom' }
    }).render();
    
    // Chart 9: Payment Methods
    const methodLabels = { 'cash': 'نقدي', 'bank_transfer': 'تحويل بنكي', 'card': 'بطاقة', 'cheque': 'شيك', 'wallet': 'محفظة' };
    new ApexCharts(document.querySelector("#chart-payment-methods"), {
        series: Object.values(chartsData.paymentMethods),
        chart: { type: 'polarArea', height: 280 },
        labels: Object.keys(chartsData.paymentMethods).map(k => methodLabels[k] || k),
        colors: ['#38ef7d', '#667eea', '#f093fb', '#feca57', '#4facfe'],
        legend: { position: 'bottom' }
    }).render();
    
    // Chart 10: Weekly Heatmap
    const days = ['السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
    const heatmapData = chartsData.weeklyRevenue.map((week, i) => ({
        name: 'الأسبوع ' + (i + 1),
        data: week.map((val, j) => ({ x: days[j], y: val }))
    }));
    new ApexCharts(document.querySelector("#chart-weekly-heatmap"), {
        series: heatmapData,
        chart: { type: 'heatmap', height: 280, toolbar: { show: false }},
        colors: ['#667eea'],
        dataLabels: { enabled: false },
        xaxis: { type: 'category' }
    }).render();
});
</script>
@endpush
