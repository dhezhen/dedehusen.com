<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Nama proyek')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),
                TextColumn::make('publication_state')
                    ->label('Status')
                    ->state(fn (Project $record): string => $record->publicationStatus())
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
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
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
