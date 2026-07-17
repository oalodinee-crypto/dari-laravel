<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// تحكم العقارات (إدارة العقارات المعروضة)
class PropertyController extends Controller
{
    // عرض قائمة العقارات
    public function index()
    {
        $properties = Property::with('user')->latest()->paginate(12);
        return view('properties.index', compact('properties'));
    }

    // صفحة إضافة عقار جديد
    public function create()
    {
        $this->authorize('create', Property::class);
        return view('properties.create');
    }

    // حفظ العقار
    public function store(Request $request)
    {
        $this->authorize('create', Property::class);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:apartment,villa,office,land,building',
            'status' => 'required|in:available,rented,sold,maintenance',
            'price' => 'required|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'features' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('properties', 'public');
            }
        }

        $property = auth()->user()->properties()->create(array_merge($validated, [
            'images' => $images,
        ]));

        return redirect()->route('properties.show', $property)->with('success', 'تم إضافة العقار بنجاح');
    }

    // عرض تفاصيل العقار
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    // صفحة تعديل العقار
    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        return view('properties.edit', compact('property'));
    }

    // تحديث بيانات العقار
    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:apartment,villa,office,land,building',
            'status' => 'required|in:available,rented,sold,maintenance',
            'price' => 'required|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'features' => 'nullable|array',
        ]);

        $images = $property->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('properties', 'public');
            }
        }

        $property->update(array_merge($validated, ['images' => $images]));

        return redirect()->route('properties.show', $property)->with('success', 'تم تحديث العقار بنجاح');
    }

    // حذف العقار
    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        
        if ($property->images) {
            foreach ($property->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $property->delete();
        return redirect()->route('properties.index')->with('success', 'تم حذف العقار بنجاح');
    }
}
