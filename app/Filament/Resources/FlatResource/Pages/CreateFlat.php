<?php

namespace App\Filament\Resources\FlatResource\Pages;

use App\Filament\Resources\FlatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlat extends CreateRecord
{
    protected static string $resource = FlatResource::class;

    protected function afterSave(): void
    {
        $uploadedImages = $this->data['images'] ?? [];
        $f= $this->data['flats-images'] ?? [];
        // التحقق من وجود صور مرفوعة
        if (!empty($uploadedImages)) {
            // استدعاء الدالة لتخزين الصور
            FlatResource::storeImages($this->record, $uploadedImages);
        }
    }

}
