<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi akun')
                    ->description('Data yang dipakai pengguna untuk masuk ke dashboard.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_admin')
                            ->label('Akses dashboard admin')
                            ->helperText('Akun yang sedang digunakan dan admin terakhir harus tetap memiliki akses.')
                            ->default(false)
                            ->disabled(function (?User $record): bool {
                                if ($record === null || $record->is(auth()->user())) {
                                    return $record !== null;
                                }

                                return $record->is_admin && ! User::query()
                                    ->where('is_admin', true)
                                    ->where('id', '!=', $record->getKey())
                                    ->exists();
                            }),
                    ]),
                Section::make('Kata sandi')
                    ->description('Gunakan minimal 12 karakter. Saat mengubah akun, kosongkan jika kata sandi tidak diganti.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('password')
                            ->label('Kata sandi')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->minLength(12)
                            ->confirmed()
                            ->formatStateUsing(fn (): null => null)
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                        TextInput::make('password_confirmation')
                            ->label('Ulangi kata sandi')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(false),
                    ]),
            ]);
    }
}
