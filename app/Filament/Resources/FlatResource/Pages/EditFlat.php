<?php

namespace App\Filament\Resources\FlatResource\Pages;

use App\Filament\Resources\FlatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlat extends EditRecord
{
    protected static string $resource = FlatResource::class;

    protected function afterSave(): void
    {
        // الحصول على الصور المرفوعة من النموذج
        $uploadedImages = $this->data['flats-images'] ?? [];

        // التحقق من وجود صور مرفوعة
        if (!empty($uploadedImages)) {
            // استدعاء الدالة لتحديث الصور
            FlatResource::storeImages($this->record, $uploadedImages);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
