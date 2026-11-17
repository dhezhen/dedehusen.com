<?php

namespace App\Filament\Resources\CourseMaterials\Pages;

use App\Filament\Resources\CourseMaterials\CourseMaterialResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateCourseMaterial extends CreateRecord
{
    protected static string $resource = CourseMaterialResource::class;

    public function getTitle(): string
    {
        return 'Tambah materi kuliah';
    }

    public function getBreadcrumb(): string
    {
        return 'Tambah';
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()->label('Simpan materi');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()->label('Batal');
    }
}
