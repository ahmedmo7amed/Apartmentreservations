<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;



class Room extends Model
{
    use SoftDeletes;

    protected $table = 'rooms';

    protected $fillable = [
        'title',
        'capacity',
        'description',
        'price_per_night', // تم تصحيح الاسم من hourly_rate
        'status', // أضيف حقل الحالة
        'features', // أضيف لحقل الميزات
        'room_type_id',
    ];

    protected $casts = [
        'features' => 'array',
        'price_per_night' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    // علاقة متعددة الأشكال مع الحجوزات
//    public function bookings()
//    {
//        return $this->hasMany(Booking::class);
//    }
    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
    // عدد الحجوزات النشطة
    public function getActiveBookingsCountAttribute(): int
    {
        return $this->bookings()
            ->where('status', 'confirmed')
            ->where('time_to', '>', now())
            ->count();
    }

    // تنسيق التواريخ في JSON
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    // إعدادات الوسائط
//    public function registerMediaCollections(): void
//    {
//        $this->addMediaCollection('room_images')
//            ->useDisk('rooms')
//            ->withResponsiveImages();
//    }
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
//    public function getPricePerNightAttribute($value)
//    {
//        return $value ?? $this->roomType->price_per_night;
//    }
    public function getPricePerNightAttribute($value)
    {
        return $value ?? optional($this->roomType)->price_per_night;
    }
    public function getStatusLabelAttribute()
    {
        return $this->status === 'available' ? 'Available' : 'Unavailable';
    }
    public function isAvailableBetween($start, $end)
    {
        return $this->bookings()
            ->where('time_from', '<', $end)
            ->where('time_to', '>', $start)
            ->doesntExist();
    }
}
