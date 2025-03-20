<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    /**
     * الحقول القابلة للتعبئة.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'time_from',
        'time_to',
        'additional_information',
        'price',
        'status',
        'customer_id',
        'bookable_id',
        'bookable_type',
        'total_price',
        'booking_type',
        'user_id'

    ];

    protected $casts = [
        'status' => BookingStatus::class,
        'time_from' => 'datetime',
        'time_to' => 'datetime',
        'total_price' => 'float'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($booking) {
            $booking->total_price = $booking->calculateTotalPrice();
        });
    }

    /**
     * تعيين قيمة customer_id إلى null في حال كان الإدخال فارغاً.
     *
     * @param mixed $input
     */
    public function setCustomerIdAttribute($input)
    {
        $this->attributes['customer_id'] = $input ?? null;
    }

    /**
     * تحويل قيمة time_from إلى التنسيق الصحيح.
     *
     * @param string|null $input
     */
    public function setTimeFromAttribute($input)
    {
        if (!empty($input)) {
            try {
                $this->attributes['time_from'] = Carbon::parse($input)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $this->attributes['time_from'] = null;
            }
        } else {
            $this->attributes['time_from'] = null;
        }
    }

    /**
     * تحويل قيمة time_to إلى التنسيق الصحيح.
     *
     * @param string|null $input
     */
    public function setTimeToAttribute($input)
    {
        if (!empty($input)) {
            try {
                $this->attributes['time_to'] = Carbon::parse($input)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $this->attributes['time_to'] = null;
            }
        } else {
            $this->attributes['time_to'] = null;
        }
    }

    /**
     * العلاقة Polymorphic مع الغرف والشقق
     */
    public function bookable()
    {
        return $this->morphTo();
    }

    /**
     * الحصول على الغرفة إذا كان الحجز لغرفة
     */


    /**
     * الحصول على الشقة إذا كان الحجز لشقة
     */


    /**
     * حساب السعر الإجمالي بناءً على الفترة ونوع الحجز
     */
    public function calculateTotalPrice()
    {

        if (empty($this->time_from) || empty($this->time_to) || empty($this->bookable)) {
            return 0;
        }

        $start = Carbon::parse($this->time_from);
        $end = Carbon::parse($this->time_to);

        // حساب عدد الأيام (يتم تقريب عدد الساعات لأعلى مقسوما على 24)
        $days = $start->diffInDays($end);
        //$days = max(1, ceil($hours / 24)); // على الأقل يوم واحد
        //dd($days);
        return $this->bookable->price * $days;
    }

    /**
     * تحديث السعر الإجمالي قبل الحفظ
     */
    public function updateTotalPrice()
    {
        $this->total_price = $this->calculateTotalPrice();
    }


    // ==================== السكوبات ====================

    public function scopeRoomBookings($query)
    {
        return $query->where('bookable_type', Room::class);
    }

    public function scopeFlatBookings($query)
    {
        return $query->where('bookable_type', Flat::class);
    }

    // ==================== الدوال المساعدة ====================

    public function isConflicting()
    {
        return static::where('bookable_type', $this->bookable_type)
            ->where('bookable_id', $this->bookable_id)
            ->where('id', '!=', $this->id) // استثناء الحجز الحالي
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('time_from', '<', $this->time_to)
                        ->where('time_to', '>', $this->time_from);
                });
            })
            ->exists();
    }

    /**
     * معرفة عدد الأيام للحجز
     */
    public function getDurationInDaysAttribute()
    {
        if (!$this->time_from || !$this->time_to) {
            return 0;
        }

        $start = Carbon::parse($this->time_from);
        $end = Carbon::parse($this->time_to);
        $hours = $end->diffInHours($start);
        return max(1, ceil($hours / 24)); // على الأقل يوم واحد
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
//////////////////new change
///
///

// app/Models/Booking.php
    public static function isAvailable($bookableType, $bookableId, $timeFrom, $timeTo, $ignoreId = null)
    {
        return !static::where('bookable_type', $bookableType)
            ->where('bookable_id', $bookableId)
            ->where(function ($query) use ($timeFrom, $timeTo) {
                $query->whereBetween('time_from', [$timeFrom, $timeTo])
                    ->orWhereBetween('time_to', [$timeFrom, $timeTo])
                    ->orWhere(function ($query) use ($timeFrom, $timeTo) {
                        $query->where('time_from', '<', $timeFrom)
                            ->where('time_to', '>', $timeTo);
                    });
            })
            ->when($ignoreId, function ($query, $ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->exists();
    }


}
