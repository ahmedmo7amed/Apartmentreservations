<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Flat;
use App\Models\Room;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['bookable_type'] = $data['booking_type'] === 'flat' ? Flat::class : Room::class;
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';
        unset($data['booking_type']); // إزالة الحقل غير الموجود في قاعدة البيانات

        //dd($data); // عرض البيانات قبل الحفظ

        return $data;
    }
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        //dd($data); // عرض البيانات قبل الحفظ

        return static::getModel()::create($data);
    }

}
