<?php

namespace App\Models;


use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use DateTimeInterface;


class Flat extends Model
{

    use SoftDeletes;

    protected $table = 'flats';

    protected $fillable = [
        'title',
        'description',
        'address',
        'city',
        'state',
        'country',
        'price',
        'bedrooms',
        'bathrooms',
        'floor_area',
        'status', // إضافة حقل الحالة بدل is_available
        'features' , // إضافة حقل الميزات
        'price_per_night',
        'images'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'floor_area' => 'integer',
        'status' => 'string', // تغيير لنوع الحالة
        'features' => 'array',
        'price_per_night' => 'decimal:2',
        'images' => 'array'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_SLASHES);
    }

    protected static function booted(): void{
        static::deleted(function (Flat $flat) {
            foreach ($flat->images as $image) {
                Storage::delete("public/$image");
            }
        });

        static::updated(function (Flat $flat) {
            $imagesToDelete = array_diff($flat->getOriginal('images'), $flat->images);
            foreach ($imagesToDelete as $image) {
                Storage::delete("public/$image");
            }
        });

    }
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
//    public function bookings()
//    {
//        return $this->hasMany(Booking::class);
//    }

    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public function getActiveBookingsCountAttribute(): int
    {
        return $this->bookings()
            ->where('status', 'confirmed')
            ->where('time_to', '>', now())
            ->count();
    }


//    public function isAvailableBetween($startDate, $endDate)
//    {
//        return $this->bookings()
//            ->where(function ($query) use ($startDate, $endDate) {
//                $query->where('time_from', '>=', $startDate)
//                    ->where('time_to', '<=', $endDate);
//            })
//            ->doesntExist(); // تعني أن لا توجد حجوزات في هذه الفترة
//    }

    public function isAvailableBetween($start, $end)
    {
        return $this->bookings()
            ->where('time_from', '<', $end)
            ->where('time_to', '>', $start)
            ->doesntExist();
    }
}
