<?php
namespace App\Http\Controllers;
use App\Models\Room;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return Room::all();
    }

    public function show(Room $room)
    {
        return Inertia::render('Room/Show', [
            'room' => $room->load('roomType')
        ]);
    }
    public function create()
    {
        dd("test");
        return Inertia::render('Room/Create');
    }
    public function store()
    {
        Room::create(
            request()->validate([
                'name' => ['required'],
                'description' => ['required'],
                'room_type_id' => ['required'],
                'floor' => ['required'],
                'number' => ['required'],
                'price' => ['required'],
                'capacity' => ['required'],
                'size' => ['required'],
            ])
        );
        return Inertia::render('Room/Index', [
            'rooms' => Room::with('roomType')->get()
        ]);
    }
    public function edit(Room $room)
    {
        return Inertia::render('Room/Edit', [
            'room' => $room->load('roomType')
        ]);
    }
    public function update(Room $room)
    {
        $room->update(
            request()->validate([
                'name' => ['required'],
                'description' => ['required'],
                'room_type_id' => ['required'],
                'floor' => ['required'],
                'number' => ['required'],
                'price' => ['required'],
                'capacity' => ['required'],
                'size' => ['required'],
            ])
        );
        return Inertia::render('Room/Index', [
            'rooms' => Room::with('roomType')->get()
        ]);
    }
    public function destroy(Room $room)
    {
        $room->delete();
        return Inertia::render('Room/Index', [
            'rooms' => Room::with('roomType')->get()
        ]);
    }

}
