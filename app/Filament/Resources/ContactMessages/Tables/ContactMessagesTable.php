<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('topic')->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('read_at')->dateTime()->placeholder('Belum dibaca')->sortable(),
            ])
            ->filters([
                TernaryFilter::make('read_at')->label('Status baca')->nullable(),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('markRead')->label('Tandai dibaca')->visible(fn ($record) => $record->read_at === null)->action(fn ($record) => $record->update(['read_at' => now()])),
            ]);
    }
}
