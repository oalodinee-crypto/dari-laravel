<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingCategory;
use App\Models\BuildingType;
use App\Models\User;
use Illuminate\Http\Request;

// تحكم المباني (إدارة المباني والوحدات)
class BuildingController extends Controller
{
    // عرض قائمة المباني
    public function index()
    {
        $buildings = Building::with(['manager', 'category', 'type', 'units.contracts', 'units.invoices'])->withCount('units')->latest()->paginate(12);
        $categories = BuildingCategory::all();
        $types = BuildingType::all();
        return view('buildings.index', compact('buildings', 'categories', 'types'));
    }

    // صفحة إضافة مبنى جديد
    public function create()
    {
        $managers = User::role(['admin', 'manager', 'Manager'])->get();
        $categories = BuildingCategory::all();
        $types = BuildingType::all();
        return view('buildings.create', compact('managers', 'categories', 'types'));
    }

    // حفظ المبنى الجديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:buildings',
            'building_type' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'floors_count' => 'required|integer|min:1',
            'year_built' => 'nullable|integer',
            'total_area' => 'nullable|numeric',
            'manager_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,maintenance,inactive',
            'category_id' => 'nullable|exists:building_categories,id',
            'type_id' => 'nullable|exists:building_types,id',
        ]);

        Building::create($validated);
        return redirect()->route('buildings.index')->with('success', 'تم إضافة المبنى بنجاح');
    }

    // عرض تفاصيل المبنى (والوحدات التابعة له)
    public function show(Building $building)
    {
        $building->load(['manager', 'units.tenant']);
        return view('buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        $managers = User::role(['admin', 'manager', 'Manager'])->get();
        $categories = BuildingCategory::all();
        $types = BuildingType::all();
        return view('buildings.edit', compact('building', 'managers', 'categories', 'types'));
    }

    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:buildings,code,' . $building->id,
            'building_type' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'floors_count' => 'required|integer|min:1',
            'year_built' => 'nullable|integer',
            'total_area' => 'nullable|numeric',
            'manager_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,maintenance,inactive',
            'category_id' => 'nullable|exists:building_categories,id',
            'type_id' => 'nullable|exists:building_types,id',
        ]);

        $building->update($validated);
        return redirect()->route('buildings.show', $building)->with('success', 'تم تحديث المبنى بنجاح');
    }

    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'تم حذف المبنى بنجاح');
    }
}
