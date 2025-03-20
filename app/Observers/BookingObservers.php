<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Flat;
use Carbon\Carbon;

class BookingObservers
{
    /**
     * دالة لحساب السعر الإجمالي من خلال Filament
     */
//    public static function calculateTotalPrice($get, $set)
//    {
//        $timeFrom = $get('time_from');
//        $timeTo = $get('time_to');
//        $bookingType = $get('booking_type');
//        $roomId = $get('room_id');
//        $flatId = $get('flat_id');
//
//        if (empty($timeFrom) || empty($timeTo)) {
//            $set('total_price', 0);
//            return;
//        }
//
//        try {
//            $start = Carbon::parse($timeFrom);
//            $end = Carbon::parse($timeTo);
//
//            if ($start->gt($end)) {
//                $set('total_price', 0);
//                return;
//            }
//
//            // حساب الأيام بدقة
//            $days = $start->diffInDays($end);
//            $days = $days > 0 ? $days : 1; // ضمان يوم واحد على الأقل
//
//            $price = 0;
//            if ($bookingType === 'room' && $roomId) {
//                $room = Room::find($roomId);
//                $price = $room ? $room->price_per_night : 0;
//            } elseif ($bookingType === 'flat' && $flatId) {
//                $flat = Flat::find($flatId);
//                $price = $flat ? $flat->price_per_night : 0;
//            }
//
//            $totalPrice = $price * $days;
//            $set('total_price', $totalPrice);
//            dd($totalPrice);
//        } catch (\Exception $e) {
//            $set('total_price', 0);
//            \Log::error("حساب السعر فشل: {$e->getMessage()}");
//        }
//    }


    public static function calculateTotalPrice($get, $set)
    {
        $timeFrom = $get('time_from');
        $timeTo = $get('time_to');
        $bookingType = $get('booking_type');
        $roomId = $get('bookable_id');
        $flatId = $get('bookable_id');
        $bookable_id = $get('bookable_id');
        $bookingType = class_basename($bookingType);
        if (empty($timeFrom) || empty($timeTo) || empty($bookingType)) {
            $set('total_price', 0);
            return;
        }
        try {
            $start = Carbon::parse($timeFrom);
            $end = Carbon::parse($timeTo);

            if ($start->gt($end)) {
                $set('total_price', 0);
                return;
            }
            // حساب عدد الأيام مع مراعاة الوقت
            $days = $start->diffInDays($end);
            if ($end->format('H:i') > $start->format('H:i')) {
                $days += 1;
            }
            // تحديد النوع والسعر
            $price = 0;
            if ($bookingType === 'room' && $roomId) {
                $room = Room::find($roomId);
                $price = $room ? (float)$room->price_per_night : 0;
            } elseif ($bookingType === 'flat' && $flatId) {
                $flat = Flat::find($flatId);
                $price = $flat ? (float)$flat->price : 0;
            }
            $totalPrice = $price * $days;
            $set('total_price', $totalPrice);
            //dd($totalPrice);
        } catch (\Exception $e) {
            $set('total_price', 0);
            \Log::error("Error calculating price: " . $e->getMessage());
        }
    }
    /**
     * Handle the Booking "creating" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function creating(Booking $booking)
    {
        // تحديد نوع الحجز (bookable_type و bookable_id)
        if ($booking->room_id) {
            $booking->bookable_type = Room::class;
            $booking->bookable_id = $booking->room_id;
            $booking->booking_type = 'room';
        } elseif ($booking->flat_id) {
            $booking->bookable_type = Flat::class;
            $booking->bookable_id = $booking->flat_id;
            $booking->booking_type = 'flat';
        }

        //////////////////////////////////////   new Update


        if (!Booking::isAvailable($booking->bookable_type, $booking->bookable_id, $booking->time_from, $booking->time_to)) {
            throw new \Exception('الشقة غير متاحة في التواريخ المحددة.');
        }

        ///////////////////////////////////// End new Update

        $booking->updateTotalPrice();
    }

    /**
     * Handle the Booking "updating" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function updating(Booking $booking)
    {
        // تحديث نوع الحجز عند التعديل
        if ($booking->isDirty('room_id') || $booking->isDirty('flat_id')) {
            if ($booking->room_id) {
                $booking->bookable_type = Room::class;
                $booking->bookable_id = $booking->room_id;
                $booking->booking_type = 'room';
            } elseif ($booking->flat_id) {
                $booking->bookable_type = Flat::class;
                $booking->bookable_id = $booking->flat_id;
                $booking->booking_type = 'flat';
            } else {
                $booking->bookable_type = null;
                $booking->bookable_id = null;
            }
        }

        $booking->updateTotalPrice();
    }
}
