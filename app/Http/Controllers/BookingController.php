<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flat;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
//    public function book(Request $request)
//    {
//        $request->validate([
//            'time_from' => 'required|date',
//            'time_to' => 'required|date|after:time_from',
//            'additional_information' => 'nullable|string',
//            'amount' => 'required|numeric',
//            'status' => 'required|in:confirmed,pending,cancelled',
//            'customer_id' => 'required|exists:customers,id',
//            'room_id' => 'required|exists:rooms,id',
//            'total_price' => 'required|numeric',
//            'booking_type' => 'required|in:hourly,daily,weekly,monthly',
//            'type' => 'required|in:room,flat',
//            'id' =>'required|exists:rooms,id|exists:flats,id'
//            ]);
//        $exists = Booking::where(function ($query) use ($request) {
//            if($request->type == 'room') {
//                $query->where('room_id', $request->id);
//            } else {
//                $query->where('flat_id', $request->id);
//            }})->where(function ($query) use ($request) {
//                $query->whereBetween('time_from', [$request->time_from, $request->time_to])
//                    ->orWhereBetween('time_to', [$request->time_from, $request->time_to])
//                    ->orWhere(function ($query) use ($request) {
//                        $query->where('time_from', '<=' , $request->time_from)
//                            ->where('time_to', '>=', $request->time_to);});})
//            ->exists();
//        if($exists) {
//            return response()->json(['message' => '⚠ غير متاح'], 400);
//        }
//
//        $booking = new Booking();
//        $booking->customer_id = auth()->id();
//        $booking->time_from = $request->time_from;
//        $booking->time_to = $request->time_to;
//        $booking->additional_information = $request->additional_information;
//        $booking->amount = $request->amount;
//        $booking->status = 'pending';
//        if($request->type == 'room') {
//            $booking->room_id = $request->id;
//            $booking->price = Room::find($request->id)->price_per_night;
//        } else {
//            $booking->flat_id = $request->id;
//            $booking->price = Flat::find($request->id)->price;
//        }
//        $booking->save();
//        return response()->json(['message' => 'تم الحجز بنجاح' ,'booking' => $booking ], 200);
//    }

//    public function update(Request $request, $id)
//    {
//        $request->validate([
//            'time_from' => 'required|date',
//            'time_to' => 'required|date|after:time_from',
//            'additional_information' => 'nullable|string',
//            'amount' => 'required|numeric',
//            'status' => 'required|in:confirmed,pending,cancelled',
//            'customer_id' => 'required|exists:customers,id',
//            'room_id' => 'required|exists:rooms,id',
//            'total_price' => 'required|numeric',
//            'booking_type' => 'required|in:hourly,daily,weekly,monthly',
//            'type' => 'required|in:room,flat',
//            'id' =>'required|exists:rooms,id|exists:flats,id'
//        ]);
//        $booking = Booking::find($id);
//        $booking->customer_id = auth()->id();
//        $booking->time_from = $request->time_from;
//        $booking->time_to = $request->time_to;
//        $booking->additional_information = $request->additional_information;
//        $booking->amount = $request->amount;
//        $booking->status = 'pending';
//        if($request->type == 'room') {
//            $booking->room_id = $request->id;
//            $booking->price = Room::find($request->id)->price;
//        } else {
//            $booking->flat_id = $request->id;
//            $booking->price = Flat::find($request->id)->price;
//        }
//        $booking->save();
//        return response()->json(['message' => 'تم تحديث الحجز بنجاح' ,'booking' => $booking ], 200);
//    }
    private function saveBooking(Request $request, Booking $booking = null)
    {
        $booking = $booking ?? new Booking();
        $booking->user_id = auth()->id();
        $booking->time_from = $request->time_from;
        $booking->time_to = $request->time_to;
        $booking->additional_information = $request->additional_information;
        $booking->status = 'pending';
        $booking->bookable_id = $request->id;
        $booking->bookable_type = $request->type === 'room' ? 'App\\Models\\Room' : 'App\\Models\\Flat';

        if ($request->type === 'room') {
            $booking->price = Room::findOrFail($request->id)->price_per_night;
        } else {
            $booking->total_price = Flat::findOrFail($request->id)->total_price;
        }

        $booking->save();
        return $booking;
    }

    public function book(Request $request)
    {
        $request->validate([
            'time_from' => 'required|date',
            'time_to' => 'required|date|after:time_from',
            'additional_information' => 'nullable|string',
            'total_price' => 'required|numeric',
            'booking_type' => 'required|in:hourly,daily,weekly,monthly',
            'type' => 'required|in:room,flat',
            'id' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type == 'room' && !Room::where('id', $value)->exists()) {
                        $fail('الغرفة المختارة غير موجودة.');
                    } elseif ($request->type == 'flat' && !Flat::where('id', $value)->exists()) {
                        $fail('الشقة المختارة غير موجودة.');
                    }
                }
            ]
        ]);

        if ($this->checkAvailability($request)) {
            return response()->json(['message' => '⚠ غير متاح'], 400);
        }

        $booking = $this->saveBooking($request);
        return response()->json(['message' => 'تم الحجز بنجاح', 'booking' => $booking], 200);
    }

    public function update(Request $request, $id) {
        $request->validate([

            'time_from' => 'required|date',
            'time_to' => 'required|date|after:time_from',
            'additional_information' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|in:confirmed,pending,cancelled',
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'total_price' => 'required|numeric',
            'booking_type' => 'required|in:hourly,daily,weekly,monthly',
            'type' => 'required|in:room,flat',
            'id' =>'required|exists:rooms,id|exists:flats,id'

        ]);
        $booking = Booking::findOrFail($id);
        if ($booking->customer_id !== auth()->id()) {
            return response()->json(['message' => 'غير مصرح'], 403);
        }
        if ($this->checkAvailability($request, $booking->id)) {
            return response()->json(['message' => '⚠ غير متاح'], 400);
        }
        $booking = $this->saveBooking($request, $booking);
        return response()->json(['message' => 'تم تحديث الحجز بنجاح', 'booking' => $booking], 200);
    }

    private function checkAvailability(Request $request, $excludeBookingId = null)
    {
        $query = Booking::where('bookable_id', $request->id)
            ->where('bookable_type', $request->type === 'room' ? 'App\\Models\\Room' : 'App\\Models\\Flat')
            ->where(function ($query) use ($request) {
                $query->whereBetween('time_from', [$request->time_from, $request->time_to])
                    ->orWhereBetween('time_to', [$request->time_from, $request->time_to])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('time_from', '<=', $request->time_from)
                            ->where('time_to', '>=', $request->time_to);
                    });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->exists();
    }


    public function show($id)
    {
        $booking = Booking::find($id);
        return Inertia::render('BookPage', [
            'booking' => $booking,
        ]);
    }

    public function edit($id)
    {
        $booking = Booking::find($id);
        return Inertia::render('Bookings/Edit', [
            'booking' => $booking,
        ]);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);
        $booking->delete();
        return response()->json(['message' => 'تم حذف الحجز بنجاح' ], 200);
    }

    public function index()
    {
        $bookings = Booking::all();
        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    public function create()
    {
        return Inertia::render('Bookings/Create');
    }

    ////////////////////////////// New Update
    ///
    ///

    public function search(Request $request)
    {
        // التحقق من البيانات المدخلة (اختياري)
        $request->validate([
            'time_from' => 'nullable|date',
            'time_to' => 'nullable|date',
            'status' => 'nullable|in:confirmed,pending,cancelled',
            'type' => 'nullable|in:room,flat',
            'customer_id' => 'nullable|exists:customers,id',
            'room_id' => 'nullable|exists:rooms,id',
            'flat_id' => 'nullable|exists:flats,id',
        ]);

        // بناء الاستعلام
        $query = Booking::query();

        // تصفية حسب تاريخ البداية
        if ($request->filled('time_from')) {
            $query->where('time_from', '>=', $request->time_from);
        }

        // تصفية حسب تاريخ النهاية
        if ($request->filled('time_to')) {
            $query->where('time_to', '<=', $request->time_to);
        }

        // تصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // تصفية حسب نوع الحجز (غرفة أو شقة)
        if ($request->filled('type')) {
            if ($request->type === 'room') {
                $query->whereNotNull('room_id')->whereNull('flat_id');
            } elseif ($request->type === 'flat') {
                $query->whereNotNull('flat_id')->whereNull('room_id');
            }
        }

        // تصفية حسب معرف العميل
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // تصفية حسب معرف الغرفة
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        // تصفية حسب معرف الشقة
        if ($request->filled('flat_id')) {
            $query->where('flat_id', $request->flat_id);
        }

        // جلب النتائج مع ترقيم الصفحات
        $bookings = $query->paginate(10);

        // إرجاع النتائج إلى واجهة المستخدم باستخدام Inertia
        return Inertia::render('Bookings/Search', [
            'bookings' => $bookings,
            'filters' => $request->only(['time_from', 'time_to', 'status', 'type', 'customer_id', 'room_id', 'flat_id']),
        ]);
    }

}
