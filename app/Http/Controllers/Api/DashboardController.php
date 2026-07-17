<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Contract;
use App\Models\MaintenanceRequest;
use App\Models\Payment;

// وحدة تحكم لوحة المعلومات (API)
class DashboardController extends Controller
{
    // إحصائيات عامة
    public function stats()
    {
        return response()->json([
            'users_count' => User::count(),
            'buildings_count' => Building::count(),
            'units_count' => Unit::count(),
            'contracts_count' => Contract::where('status', 'active')->count(),
            'maintenance_pending' => MaintenanceRequest::where('status', 'pending')->count(),
            'total_payments' => Payment::sum('amount'),
        ]);
    }

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
            'total_properties' => \App\Models\Property::count(),
            'available_properties' => \App\Models\Property::where('status', 'available')->count(),
            'active_contracts' => Contract::where('status', 'active')->count(),
            'expiring_contracts' => Contract::where('status', 'active')->where('end_date', '<=', now()->addDays(30))->count(),
            'total_contracts' => Contract::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount') ?? 0,
            'monthly_revenue' => Payment::where('status', 'completed')->whereMonth('payment_date', now()->month)->sum('amount') ?? 0,
            'pending_invoices' => \App\Models\Invoice::where('status', 'pending')->sum('total_amount') ?? 0,
            'overdue_invoices' => \App\Models\Invoice::where('status', 'overdue')->count(),
            'overdue_amount' => \App\Models\Invoice::where('status', 'overdue')->sum('total_amount') ?? 0,
            'pending_maintenance' => MaintenanceRequest::where('status', 'pending')->count(),
            'in_progress_maintenance' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed_maintenance_month' => MaintenanceRequest::where('status', 'completed')->whereMonth('updated_at', now()->month)->count(),
            'total_maintenance' => MaintenanceRequest::count(),
            'total_complaints' => \App\Models\Complaint::count(),
            'pending_complaints' => \App\Models\Complaint::where('status', 'pending')->count(),
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
        $invoicesByStatus = \App\Models\Invoice::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();

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

        $totalInvoiced = \App\Models\Invoice::sum('total_amount') ?? 0;
        $totalCollected = Payment::where('status', 'completed')->sum('amount') ?? 0;
        $collectionRate = $totalInvoiced > 0 ? round(($totalCollected / $totalInvoiced) * 100, 1) : 0;

        $complaintsTrend = [];
        $complaintsResolved = [];
        for ($i = 1; $i <= 12; $i++) {
            $complaintsTrend[] = \App\Models\Complaint::whereYear('created_at', now()->year)->whereMonth('created_at', $i)->count();
            $complaintsResolved[] = \App\Models\Complaint::whereYear('created_at', now()->year)->whereMonth('created_at', $i)->where('status', 'resolved')->count();
        }

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

        return response()->json([
            'stats' => $stats,
            'chartsData' => $chartsData
        ]);
    }
}
