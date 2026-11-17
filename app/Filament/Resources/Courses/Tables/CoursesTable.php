<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Mata kuliah')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course_code')
                    ->label('Kode')
                    ->placeholder('Belum diisi'),
                TextColumn::make('semester')
                    ->label('Semester')
                    ->placeholder('Belum diisi'),
                TextColumn::make('materials_count')
                    ->counts('materials')
                    ->label('Jumlah materi')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()->label('Ubah'),
            ]);
    }
}
