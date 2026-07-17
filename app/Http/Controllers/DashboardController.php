<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Announcement;
use App\Models\Activity;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// تحكم لوحة القيادة الرئيسي (توجيه المستخدمين حسب الدور)
class DashboardController extends Controller
{
    // الصفحة الرئيسية (توجيه تلقائي)
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('Admin')) {
            return $this->adminDashboard();
        }
        
        if ($user->hasRole('Manager')) {
            return $this->managerDashboard();
        }
        
        if ($user->hasRole('Owner')) {
            return $this->ownerDashboard();
        }
        
        if ($user->hasRole('Resident')) {
            return $this->residentDashboard();
        }
        
        return view('dashboard.index');
    }
    
    // لوحة قيادة المدير
    public function managerDashboard()
    {
        $stats = [
            'total_buildings' => Building::count(),
            'total_units' => Unit::count(),
            'occupied_units' => Unit::where('status', 'occupied')->count(),
            'active_contracts' => Contract::where('status', 'active')->count(),
            'pending_maintenance' => MaintenanceRequest::where('status', 'pending')->count(),
            'pending_invoices' => Invoice::where('status', 'pending')->count(),
        ];
        
        $recentContracts = Contract::with(['unit', 'tenant'])->latest()->take(5)->get();
        $pendingMaintenance = MaintenanceRequest::where('status', 'pending')->latest()->take(5)->get();
        $announcements = Announcement::latest()->take(3)->get();
        
        return view('dashboard.manager', compact('stats', 'recentContracts', 'pendingMaintenance', 'announcements'));
    }
    
    // لوحة قيادة المالك
    public function ownerDashboard()
    {
        $user = auth()->user();
        
        $buildingIds = Building::where('owner_id', $user->id)->pluck('id');
        
        $stats = [
            'total_properties' => $buildingIds->count(),
            'total_units' => Unit::whereIn('building_id', $buildingIds)->count(),
            'active_contracts' => Contract::whereHas('unit', function($q) use ($buildingIds) {
                $q->whereIn('building_id', $buildingIds);
            })->where('status', 'active')->count(),
            'pending_maintenance' => MaintenanceRequest::whereHas('unit', function($q) use ($buildingIds) {
                $q->whereIn('building_id', $buildingIds);
            })->where('status', 'pending')->count(),
        ];
        
        $announcements = Announcement::latest()->take(5)->get();
        
        return view('dashboard.owner', compact('stats', 'announcements'));
    }
    
    // لوحة قيادة الساكن
    public function residentDashboard()
    {
        $user = auth()->user();
        $myContract = Contract::where('tenant_id', $user->id)->where('status', 'active')->with('unit.building')->first();
        $pendingInvoices = Invoice::where('tenant_id', $user->id)->where('status', 'pending')->get();
        $myMaintenance = MaintenanceRequest::where('user_id', $user->id)->latest()->take(5)->get();
        $announcements = Announcement::latest()->take(5)->get();
        
        return view('dashboard.resident', compact('myContract', 'pendingInvoices', 'myMaintenance', 'announcements'));
    }

    // لوحة قيادة الأدمن (الإحصائيات الشاملة)
    public function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'new_users_month' => User::whereMonth('created_at', now()->month)->count(),
            'total_buildings' => Building::count(),
            'total_units' => Unit::count(),
            'available_units' => Unit::where('status', 'available')->count(),
            'occupied_units' => Unit::where('status', 'occupied')->count(),
            'occupancy_rate' => Unit::count() > 0 ? round((Unit::where('status', 'occupied')->count() / Unit::count()) * 100, 1) : 0,
            'total_properties' => Property::count(),
            'available_properties' => Property::where('status', 'available')->count(),
            'active_contracts' => Contract::where('status', 'active')->count(),
            'expiring_contracts' => Contract::where('status', 'active')->where('end_date', '<=', now()->addDays(30))->count(),
            'total_contracts' => Contract::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount') ?? 0,
            'monthly_revenue' => Payment::where('status', 'completed')->whereMonth('payment_date', now()->month)->sum('amount') ?? 0,
            'pending_invoices' => Invoice::where('status', 'pending')->sum('total_amount') ?? 0,
            'overdue_invoices' => Invoice::where('status', 'overdue')->count(),
            'overdue_amount' => Invoice::where('status', 'overdue')->sum('total_amount') ?? 0,
            'pending_maintenance' => MaintenanceRequest::where('status', 'pending')->count(),
            'in_progress_maintenance' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed_maintenance_month' => MaintenanceRequest::where('status', 'completed')->whereMonth('updated_at', now()->month)->count(),
            'total_maintenance' => MaintenanceRequest::count(),
            'total_complaints' => Complaint::count(),
            'pending_complaints' => Complaint::where('status', 'pending')->count(),
        ];

        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[] = Payment::where('status', 'completed')
                ->whereYear('payment_date', now()->year)
                ->whereMonth('payment_date', $i)
                ->sum('amount') ?? 0;
        }

        $revenueVsExpenses = ['revenue' => [], 'expenses' => []];
        for ($i = 1; $i <= 12; $i++) {
            $revenueVsExpenses['revenue'][] = Payment::where('status', 'completed')
                ->whereYear('payment_date', now()->year)
                ->whereMonth('payment_date', $i)
                ->sum('amount') ?? 0;
            $revenueVsExpenses['expenses'][] = MaintenanceRequest::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $i)
                ->sum('cost') ?? 0;
        }

        $unitsByStatus = Unit::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
        $contractsByStatus = Contract::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
        $invoicesByStatus = Invoice::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();

        $maintenanceTrend = [];
        for ($i = 1; $i <= 12; $i++) {
            $maintenanceTrend[] = MaintenanceRequest::whereYear('created_at', now()->year)->whereMonth('created_at', $i)->count();
        }

        $usersTrend = [];
        for ($i = 1; $i <= 12; $i++) {
            $usersTrend[] = User::whereYear('created_at', now()->year)->whereMonth('created_at', $i)->count();
        }

        $unitsPerBuilding = Building::withCount('units')->orderByDesc('units_count')->take(6)->get()
            ->map(function($b) { return ['name' => $b->name, 'count' => $b->units_count]; });

        $paymentMethods = Payment::selectRaw('method, COUNT(*) as count')->groupBy('method')->pluck('count', 'method')->toArray();

        $weeklyRevenue = [];
        for ($week = 1; $week <= 4; $week++) {
            $weekData = [];
            for ($day = 0; $day < 7; $day++) {
                $date = now()->startOfMonth()->addWeeks($week - 1)->addDays($day);
                $weekData[] = Payment::where('status', 'completed')->whereDate('payment_date', $date)->sum('amount') ?? 0;
            }
            $weeklyRevenue[] = $weekData;
        }

        $totalInvoiced = Invoice::sum('total_amount') ?? 0;
        $totalCollected = Payment::where('status', 'completed')->sum('amount') ?? 0;
        $collectionRate = $totalInvoiced > 0 ? round(($totalCollected / $totalInvoiced) * 100, 1) : 0;

        $complaintsTrend = [];
        $complaintsResolved = [];
        for ($i = 1; $i <= 12; $i++) {
            $complaintsTrend[] = Complaint::whereYear('created_at', now()->year)->whereMonth('created_at', $i)->count();
            $complaintsResolved[] = Complaint::whereYear('created_at', now()->year)->whereMonth('created_at', $i)->where('status', 'resolved')->count();
        }

        $recentUsers = User::latest()->take(5)->get();
        $recentContracts = Contract::with(['unit.building', 'tenant'])->latest()->take(5)->get();
        $recentPayments = Payment::with(['tenant', 'invoice'])->latest()->take(5)->get();
        $recentMaintenance = MaintenanceRequest::with(['user'])->latest()->take(5)->get();
        $recentActivities = Activity::with('user')->latest()->take(10)->get();

        $expiringContracts = Contract::with(['unit.building', 'tenant'])
            ->where('status', 'active')
            ->where('end_date', '<=', now()->addDays(30))
            ->get();

        $overdueInvoices = Invoice::with(['unit.building', 'tenant'])
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->get();

        $chartsData = [
            'monthlyRevenue' => $monthlyRevenue,
            'revenueVsExpenses' => $revenueVsExpenses,
            'unitsByStatus' => $unitsByStatus,
            'contractsByStatus' => $contractsByStatus,
            'invoicesByStatus' => $invoicesByStatus,
            'maintenanceTrend' => $maintenanceTrend,
            'usersTrend' => $usersTrend,
            'unitsPerBuilding' => $unitsPerBuilding,
            'paymentMethods' => $paymentMethods,
            'weeklyRevenue' => $weeklyRevenue,
            'collectionRate' => $collectionRate,
            'complaintsTrend' => $complaintsTrend,
            'complaintsResolved' => $complaintsResolved,
        ];

        return view('dashboard.admin', compact(
            'stats', 'chartsData',
            'recentUsers', 'recentContracts', 'recentPayments', 'recentMaintenance',
            'recentActivities', 'expiringContracts', 'overdueInvoices'
        ));
    }

    // صفحة التقارير
    public function reports()
    {
        return view('reports.index');
    }

    // التقرير المالي
    public function financialReport()
    {
        $data = [
            'total_invoiced' => Invoice::sum('total_amount'),
            'total_collected' => Payment::where('status', 'completed')->sum('amount'),
            'pending_amount' => Invoice::where('status', 'pending')->sum('total_amount'),
            'overdue_amount' => Invoice::where('status', 'overdue')->sum('total_amount'),
        ];
        
        $monthlyData = Payment::where('status', 'completed')
            ->whereYear('payment_date', now()->year)
            ->selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->get();

        return view('reports.financial', compact('data', 'monthlyData'));
    }

    // تقرير الإشغال
    public function occupancyReport()
    {
        $buildings = Building::withCount(['units', 'units as occupied_units_count' => function($q) {
            $q->where('status', 'occupied');
        }])->get();

        return view('reports.occupancy', compact('buildings'));
    }

    // سجل النشاطات
    public function activities()
    {
        $activities = Activity::with('user')->latest()->paginate(50);
        return view('activities.index', compact('activities'));
    }

    // ═══════════════════════════════════════════════════════════
    // RESIDENT PAGES - صفحات الساكن
    // ═══════════════════════════════════════════════════════════

    public function residentUnit()
    {
        $user = auth()->user();
        $contract = Contract::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->with('unit.building')
            ->first();
        
        return view('resident.my-unit', compact('contract'));
    }

    public function residentInvoices()
    {
        $user = auth()->user();
        $invoices = Invoice::where('tenant_id', $user->id)
            ->with('unit.building')
            ->latest()
            ->paginate(15);
        
        return view('resident.my-invoices', compact('invoices'));
    }

    public function residentPayments()
    {
        $user = auth()->user();
        $payments = Payment::where('tenant_id', $user->id)
            ->with('invoice')
            ->latest()
            ->paginate(15);
        
        return view('resident.my-payments', compact('payments'));
    }

    public function residentMaintenance()
    {
        $user = auth()->user();
        $requests = MaintenanceRequest::where('user_id', $user->id)
            ->with('unit')
            ->latest()
            ->get();
        
        return view('resident.my-maintenance', compact('requests'));
    }

    public function residentComplaints()
    {
        $user = auth()->user();
        $complaints = Complaint::where('user_id', $user->id)
            ->latest()
            ->paginate(15);
        
        return view('resident.my-complaints', compact('complaints'));
    }
}