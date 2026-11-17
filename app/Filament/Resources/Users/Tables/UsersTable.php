<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_admin')
                    ->label('Akses')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Administrator' : 'Tidak ada akses')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_admin')
                    ->label('Akses dashboard')
                    ->placeholder('Semua akun')
                    ->trueLabel('Administrator')
                    ->falseLabel('Tanpa akses admin'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Ubah')
                    ->authorize(fn (User $record): bool => UserResource::canEdit($record)),
                DeleteAction::make()
                    ->label('Hapus')
                    ->authorize(fn (User $record): bool => UserResource::canDelete($record))
                    ->modalHeading('Hapus pengguna')
                    ->modalDescription('Akun ini tidak dapat digunakan lagi untuk masuk.')
                    ->modalSubmitActionLabel('Hapus pengguna'),
            ]);
    }
}
