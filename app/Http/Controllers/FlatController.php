<?php

namespace App\Http\Controllers;

use App\Models\Flat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // استرجاع جميع الشقق وعرضها
        return Inertia::render('Flats/Flats', [
            'flats' => Flat::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // عرض نموذج إنشاء شقة
        return Inertia::render('Flats/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'floor_area' => 'required|numeric',
            'status' => 'required|string',
            'features' => 'required|string',
            'price_per_night' => 'required|numeric',
        ]);

        // إنشاء شقة جديدة
        Flat::create($validatedData);

        // إعادة توجيه المستخدم إلى صفحة قائمة الشقق مع رسالة نجاح
        return redirect()->route('flats.index')->with('success', 'تم إنشاء الشقة بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // استرجاع الشقة الحالية مع الحجوزات المرتبطة بها
        $currentFlat = Flat::with('bookings')->findOrFail($id);

        // التحقق من وجود حجز مؤكد
        $hasConfirmedBooking = $currentFlat->bookings->contains('status', 'confirmed');

        // استرجاع الشقق ذات الصلة
        $relatedFlats = Flat::where('city', $currentFlat->city)
            ->where('state', $currentFlat->state)
            ->where('id', '!=', $currentFlat->id)
            ->whereBetween('price', [$currentFlat->price * 0.9, $currentFlat->price * 1.1])
            ->limit(5)
            ->get();

        // إرسال البيانات إلى الواجهة الأمامية
        return Inertia::render('FlatsDetails/FlatsDetails', [
            'flat' => $currentFlat,
            'relatedFlats' => $relatedFlats,
            'hasConfirmedBooking' => $hasConfirmedBooking
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // استرجاع الشقة لعرضها في نموذج التعديل
        $flat = Flat::findOrFail($id);
        return Inertia::render('Flats/Edit', [
            'flat' => $flat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'floor_area' => 'required|numeric',
            'status' => 'required|string',
            'features' => 'required|string',
            'price_per_night' => 'required|numeric',
        ]);

        // تحديث الشقة
        $flat = Flat::findOrFail($id);
        $flat->update($validatedData);

        // إعادة توجيه المستخدم إلى صفحة قائمة الشقق مع رسالة نجاح
        return redirect()->route('flats.index')->with('success', 'تم تحديث الشقة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // حذف الشقة
        $flat = Flat::findOrFail($id);
        $flat->delete();

        // إعادة توجيه المستخدم إلى صفحة قائمة الشقق مع رسالة نجاح
        return redirect()->route('flats.index')->with('success', 'تم حذف الشقة بنجاح.');
    }
}
