<?php

namespace App\Filament\Resources\CourseMaterials\Pages;

use App\Filament\Resources\CourseMaterials\CourseMaterialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCourseMaterial extends EditRecord
{
    protected static string $resource = CourseMaterialResource::class;

    public function getTitle(): string
    {
        return 'Ubah materi kuliah';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->label('Hapus materi'),
        ];
    }
}
