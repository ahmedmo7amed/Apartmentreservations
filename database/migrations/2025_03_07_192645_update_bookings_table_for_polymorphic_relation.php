<?php
use App\Models\Booking;
use App\Models\Flat;
use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
//public function up() {
//Schema::table('bookings', function (Blueprint $table) {
//// إضافة الأعمدة الجديدة
//$table->string('bookable_type')->nullable();
//$table->unsignedBigInteger('bookable_id')->nullable();
//$table->index(['bookable_type', 'bookable_id']);
//});
//
//// ترحيل البيانات الموجودة
//Booking::whereNotNull('room_id')->get()->each(function ($booking) {
//$booking->update([
//'bookable_type' => Room::class,
//'bookable_id' => $booking->room_id,
//]);
//});
//
//Booking::whereNotNull('flat_id')->get()->each(function ($booking) {
//$booking->update([
//'bookable_type' => Flat::class,
//'bookable_id' => $booking->flat_id,
//]);
//});
//
//Schema::table('bookings', function (Blueprint $table) {
//// حذف الأعمدة القديمة
//$table->dropColumn(['room_id', 'flat_id']);
//});
//}
//
//public function down() {
//Schema::table('bookings', function (Blueprint $table) {
//$table->unsignedBigInteger('room_id')->nullable();
//$table->unsignedBigInteger('flat_id')->nullable();
//});
//
//Booking::whereNotNull('bookable_type')->get()->each(function ($booking) {
//if ($booking->bookable_type === Room::class) {
//$booking->update(['room_id' => $booking->bookable_id]);
//} elseif ($booking->bookable_type === Flat::class) {
//$booking->update(['flat_id' => $booking->bookable_id]);
//}
//});
//
//Schema::table('bookings', function (Blueprint $table) {
//$table->dropColumn(['bookable_type', 'bookable_id']);
//});
//}
};
