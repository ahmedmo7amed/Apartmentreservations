<?php

use App\Filament\Resources\BookingResource;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\BookingController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UsersController;
use App\Models\Booking;
use App\Models\Flat;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'flats' => Flat::all(),
    ]);
});

Route::get('/test-session', function () {
    $sessionId = session()->getId();
    \Log::info('Accessing session:', ['session_id' => $sessionId]);

    return 'Session ID logged.';
})->name('test-session');

Route::middleware(['auth' , 'verified'])->group(function (){

    Route::group(['prefix' => 'users'], function (){
        Route::get('/' ,[UsersController::class , 'index'])->name('index');
        Route::post('/create', [UsersController::class, 'store'])->name('users.store');
        Route::get('{id}/show', [UsersController::class , 'show'])->name('users.show');
    });

});

Route::resource('permission',PermissionController::class);

Route::get('search', [BookingController::class, 'search'])->name('search');

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/booked', [RoomController::class, 'bookedRooms'])->name('rooms.booked');

Route::get('/flats', [FlatController::class, 'index'])->name('flats');
Route::get('/flats/{flat}', [FlatController::class, 'show'])->name('flats.show');
Route::get('/flats/booked', [FlatController::class, 'bookedFlats'])->name('flats.booked');

// مسارات تسجيل الدخول للعملاء (customers)
Route::get('/login', function () {
    return Inertia::render('Auth/CustomerLogin');
})->name('login');
//Route::get('login', [CustomerController::class, 'showLoginForm'])->name('login');
Route::post('login', [CustomerController::class, 'login'])->name('Customer.login.store');
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
Route::get('register', [CustomerController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [CustomerController::class, 'register'])->name("register");

// مسارات الحجوزات
Route::prefix('bookings')->middleware(['auth'])->group(function () {
   // Route::get('/', [BookingController::class, 'index'])->name('bookings.index');           // عرض جميع الحجوزات
    Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');  // نموذج إنشاء حجز
    Route::post('/book/{id}', [BookingController::class, 'book'])->name('bookings.book');       // إنشاء حجز جديد
//   Route::get('/{id}', [BookingController::class, 'show'])->name('bookings.show');        // عرض تفاصيل الحجز

    Route::get('/check-availability', function (Request $request) {
        $booking = Booking::where('bookable_type', $request->bookable_type)
            ->where('bookable_id', $request->bookable_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('time_from', [$request->time_from, $request->time_to])
                    ->orWhereBetween('time_to', [$request->time_from, $request->time_to])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('time_from', '<=', $request->time_from)
                            ->where('time_to', '>=', $request->time_to);
                    });
            })
            ->first();

        if ($booking) {
            return response()->json([
                'available' => false,
                'booking' => [
                    'id' => $booking->id,
                    'time_from' => $booking->time_from,
                    'time_to' => $booking->time_to,
                    'status' => $booking->status,
                    'total_price' => $booking->total_price,
                    'customer_id' => $booking->customer_id
                ]
            ]);
        }

        return response()->json(['available' => true]);
    });

    Route::get('/bookings/{id}/details', function ($id) {
        $booking = \App\Models\Booking::where('flat_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        return response()->json([
            'booking' => $booking,
        ]);
    });

//    Route::middleware(['web', 'inertia'])->group(function () {
//        Route::get('/bookings/show/{id}', function ($id) {
//            // استرجاع الشقة بناءً على الـ ID
//            $flat = \App\Models\Flat::findOrFail($id);
//
//            // استرجاع التواريخ ورسالة النجاح من الطلب
//            $startDate = request('start_date');
//            $endDate = request('end_date');
//            $successMessage = request('success');
//
//            // إرسال البيانات إلى الصفحة
//            return Inertia::render('BookPage', [
//                'flat' => $flat,
//                'start_date' => $startDate,
//                'end_date' => $endDate,
//                'success' => $successMessage,
//            ]);
//        })->name('bookings.show');
//    });

    Route::get('/bookings/show/{id}', function ($id) {
        $flat = \App\Models\Flat::findOrFail($id);
        $booking = \App\Models\Booking::where('flat_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        return Inertia::render('BookPage', [
            'flat' => $flat,
            'booking' => $booking,
            'success' => request('success'),
        ]);
    })->name('bookings.show');

    Route::get('/{id}', function ($id) {
        return Inertia::render('BookPage', [
            'flat' => \App\Models\Flat::findOrFail($id),
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
        ]);
    })->name('bookings.show');

    Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('bookings.edit');   // نموذج تعديل الحجز
    Route::put('/{id}', [BookingController::class, 'update'])->name('bookings.update');    // تحديث الحجز
    Route::delete('/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy'); // حذف الحجز
    Route::get('/search', [BookingController::class, 'search'])->name('bookings.search');  // البحث عن الحجوزات

});

Route::get('/check-availability', function (Request $request) {
    $available = Booking::isAvailable(
        $request->bookable_type,
        $request->bookable_id,
        $request->time_from,
        $request->time_to
    );
    return response()->json(['available' => $available]);
});

Route::get('/available', [BookingController::class, 'available'])->name('bookings.available');

//return Booking::all();
Route::get('/test', function () {
    $table = Booking::with('Customer')->get();
    return $table;
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
    Route::post('booking', [BookingController::class, 'book'])->name('booking.book');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
