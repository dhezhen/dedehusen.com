<?php

namespace App\Filament\Resources\CourseMaterials\Tables;

use App\Enums\CourseMaterialType;
use App\Models\CourseMaterial;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CourseMaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul materi')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('course.name')
                    ->label('Mata kuliah')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('material_type')
                    ->label('Jenis')
                    ->formatStateUsing(fn (string $state): string => CourseMaterialType::tryFrom($state)?->label() ?? ucfirst($state))
                    ->badge(),
                TextColumn::make('publication_state')
                    ->label('Status')
                    ->state(fn (CourseMaterial $record): string => $record->publicationStatus())
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Terbit' => 'success',
                        'Terjadwal' => 'info',
                        'Tanggal belum diatur' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('published_at')
                    ->label('Tanggal terbit')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('course')
                    ->label('Mata kuliah')
                    ->relationship('course', 'name'),
                SelectFilter::make('material_type')
                    ->label('Jenis materi')
                    ->options(CourseMaterialType::options()),
                TernaryFilter::make('is_published')
                    ->label('Status publikasi')
                    ->placeholder('Semua status')
                    ->trueLabel('Aktif, termasuk terjadwal')
                    ->falseLabel('Draf'),
            ])
            ->recordActions([
                EditAction::make()->label('Ubah'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Hapus dipilih'),
                ]),
            ]);
    }
}
