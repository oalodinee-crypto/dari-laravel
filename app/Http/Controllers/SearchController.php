<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Building;
use App\Models\Unit;
use App\Models\User;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Complaint;
use App\Models\Announcement;

// تحكم البحث الشامل
class SearchController extends Controller
{
    // تنفيذ البحث (يوجه حسب دور المستخدم)
    public function index(Request $request)
    {
        $query = $request->input('search', '');
        $filter = $request->input('filter', 'all');
        
        // تهيئة المصفوفة بقيم فارغة لكل الأقسام
        $results = [
            'buildings' => collect(),
            'units' => collect(),
            'users' => collect(),
            'contracts' => collect(),
            'invoices' => collect(),
            'payments' => collect(),
            'maintenance' => collect(),
            'complaints' => collect(),
            'announcements' => collect(),
        ];

        if (empty($query)) {
            return view('search.results', compact('results', 'query', 'filter'));
        }

        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $results = array_merge($results, $this->searchAsAdmin($query, $filter));
        } elseif ($user->hasRole('Manager')) {
            $results = array_merge($results, $this->searchAsManager($query, $filter, $user));
        } else {
            $results = array_merge($results, $this->searchAsResident($query, $filter, $user));
        }

        return view('search.results', compact('results', 'query', 'filter'));
    }

    // بحث المديرين والمشرفين (بحث شامل)
    private function searchAsAdmin($query, $filter)
    {
        $results = [];

        if ($filter === 'all' || $filter === 'buildings') {
            try {
                $results['buildings'] = Building::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('code', 'LIKE', "%{$query}%")
                    ->orWhere('address', 'LIKE', "%{$query}%")
                    ->limit(10)->get();
            } catch (\Exception $e) {
                $results['buildings'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'units') {
            try {
                $results['units'] = Unit::where('unit_number', 'LIKE', "%{$query}%")
                    ->limit(10)->get();
            } catch (\Exception $e) {
                $results['units'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'users') {
            try {
                $results['users'] = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('phone', 'LIKE', "%{$query}%")
                    ->limit(10)->get();
            } catch (\Exception $e) {
                $results['users'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'contracts') {
            try {
                $results['contracts'] = Contract::where('contract_number', 'LIKE', "%{$query}%")
                    ->limit(10)->get();
            } catch (\Exception $e) {
                $results['contracts'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'invoices') {
            try {
                $results['invoices'] = Invoice::where('invoice_number', 'LIKE', "%{$query}%")
                    ->limit(10)->get();
            } catch (\Exception $e) {
                $results['invoices'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'payments') {
            try {
                $results['payments'] = Payment::limit(10)->get();
            } catch (\Exception $e) {
                $results['payments'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'maintenance') {
            try {
                $results['maintenance'] = MaintenanceRequest::limit(10)->get();
            } catch (\Exception $e) {
                $results['maintenance'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'complaints') {
            try {
                $results['complaints'] = Complaint::limit(10)->get();
            } catch (\Exception $e) {
                $results['complaints'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'announcements') {
            try {
                $results['announcements'] = Announcement::where('title', 'LIKE', "%{$query}%")
                    ->limit(10)->get();
            } catch (\Exception $e) {
                $results['announcements'] = collect();
            }
        }

        return $results;
    }

    // بحث ملاك العقارات (بحث في عقاراتهم فقط)
    private function searchAsManager($query, $filter, $user)
    {
        $results = [];
        
        try {
            $managedBuildingIds = Building::where('manager_id', $user->id)->pluck('id')->toArray();
        } catch (\Exception $e) {
            $managedBuildingIds = [];
        }

        if ($filter === 'all' || $filter === 'buildings') {
            try {
                $results['buildings'] = Building::where('manager_id', $user->id)
                    ->where(function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('code', 'LIKE', "%{$query}%");
                    })->limit(10)->get();
            } catch (\Exception $e) {
                $results['buildings'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'units') {
            try {
                $results['units'] = Unit::whereIn('building_id', $managedBuildingIds)
                    ->where('unit_number', 'LIKE', "%{$query}%")
                    ->limit(10)->get();
            } catch (\Exception $e) {
                $results['units'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'contracts') {
            try {
                $results['contracts'] = Contract::whereHas('unit', function($q) use ($managedBuildingIds) {
                    $q->whereIn('building_id', $managedBuildingIds);
                })->where('contract_number', 'LIKE', "%{$query}%")->limit(10)->get();
            } catch (\Exception $e) {
                $results['contracts'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'invoices') {
            try {
                $results['invoices'] = Invoice::whereHas('contract.unit', function($q) use ($managedBuildingIds) {
                    $q->whereIn('building_id', $managedBuildingIds);
                })->where('invoice_number', 'LIKE', "%{$query}%")->limit(10)->get();
            } catch (\Exception $e) {
                $results['invoices'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'maintenance') {
            try {
                $results['maintenance'] = MaintenanceRequest::whereHas('unit', function($q) use ($managedBuildingIds) {
                    $q->whereIn('building_id', $managedBuildingIds);
                })->limit(10)->get();
            } catch (\Exception $e) {
                $results['maintenance'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'complaints') {
            try {
                $results['complaints'] = Complaint::whereHas('unit', function($q) use ($managedBuildingIds) {
                    $q->whereIn('building_id', $managedBuildingIds);
                })->limit(10)->get();
            } catch (\Exception $e) {
                $results['complaints'] = collect();
            }
        }

        return $results;
    }

    // بحث السكان (بحث في بياناتهم فقط)
    private function searchAsResident($query, $filter, $user)
    {
        $results = [];

        if ($filter === 'all' || $filter === 'contracts') {
            try {
                $results['contracts'] = Contract::where('tenant_id', $user->id)
                    ->where('contract_number', 'LIKE', "%{$query}%")
                    ->limit(10)->get();
            } catch (\Exception $e) {
                $results['contracts'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'invoices') {
            try {
                $results['invoices'] = Invoice::whereHas('contract', function($q) use ($user) {
                    $q->where('tenant_id', $user->id);
                })->where('invoice_number', 'LIKE', "%{$query}%")->limit(10)->get();
            } catch (\Exception $e) {
                $results['invoices'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'payments') {
            try {
                $results['payments'] = Payment::whereHas('invoice.contract', function($q) use ($user) {
                    $q->where('tenant_id', $user->id);
                })->limit(10)->get();
            } catch (\Exception $e) {
                $results['payments'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'maintenance') {
            try {
                $results['maintenance'] = MaintenanceRequest::where('user_id', $user->id)->limit(10)->get();
            } catch (\Exception $e) {
                $results['maintenance'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'complaints') {
            try {
                $results['complaints'] = Complaint::where('user_id', $user->id)->limit(10)->get();
            } catch (\Exception $e) {
                $results['complaints'] = collect();
            }
        }

        if ($filter === 'all' || $filter === 'announcements') {
            try {
                $results['announcements'] = Announcement::where('title', 'LIKE', "%{$query}%")->limit(10)->get();
            } catch (\Exception $e) {
                $results['announcements'] = collect();
            }
        }

        return $results;
    }
}