<?php

namespace App\Filament\Resources\CourseMaterials;

use App\Filament\Resources\CourseMaterials\Pages\CreateCourseMaterial;
use App\Filament\Resources\CourseMaterials\Pages\EditCourseMaterial;
use App\Filament\Resources\CourseMaterials\Pages\ListCourseMaterials;
use App\Filament\Resources\CourseMaterials\Schemas\CourseMaterialForm;
use App\Filament\Resources\CourseMaterials\Tables\CourseMaterialsTable;
use App\Models\CourseMaterial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseMaterialResource extends Resource
{
    protected static ?string $model = CourseMaterial::class;

    protected static ?string $modelLabel = 'materi kuliah';

    protected static ?string $pluralModelLabel = 'materi kuliah';

    protected static ?string $navigationLabel = 'Materi kuliah';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return CourseMaterialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CourseMaterialsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourseMaterials::route('/'),
            'create' => CreateCourseMaterial::route('/create'),
            'edit' => EditCourseMaterial::route('/{record}/edit'),
        ];
    }
}
