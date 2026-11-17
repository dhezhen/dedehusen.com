<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('site_name')->label('Nama situs')->searchable(),
                TextColumn::make('hero_title')->label('Judul beranda')->searchable(),
                TextColumn::make('font_display')->label('Font judul'),
                TextColumn::make('font_body')->label('Font isi'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
