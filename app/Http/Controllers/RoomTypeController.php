<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //'name',
    //        'description',
    //        'price_per_night',
    //        'capacity',
    //        'size'
    public function index()
    {
        return Inertia::render('RoomTypes/Index', [
            'roomTypes' => RoomType::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('RoomTypes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = $request->validate([
            'name' => 'required',
            'price_per_night' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'size' => 'required',
        ]);

        RoomType::create($request);

        return redirect()->route('room-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('RoomTypes/Show', [
            'roomType' => RoomType::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $roomType = RoomType::findOrFail($id);

        return Inertia::render('RoomTypes/Edit', [
            'roomType' => $roomType
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request = $request->validate([
            'name' => 'required',
            'price_per_night' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'size' => 'required',
        ]);
        $roomType = RoomType::findOrFail($id);
        $roomType->update($request);

        return redirect()->route('room-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        RoomType::findOrFail($id)->delete();

        return redirect()->route('room-types.index');
    }
}
