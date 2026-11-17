<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas mata kuliah')
                    ->description('Materi akan dikelompokkan berdasarkan mata kuliah ini.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama mata kuliah')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, Set $set, Get $get): void {
                                if (blank($get('slug')) && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Id tautan')
                            ->helperText('Dibuat dari nama mata kuliah. Gunakan huruf, angka, dan tanda hubung.')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash']),
                        TextInput::make('course_code')
                            ->label('Kode mata kuliah')
                            ->maxLength(40),
                        TextInput::make('semester')
                            ->label('Semester')
                            ->helperText('Contoh: Semester 1 atau Semester 2.')
                            ->maxLength(40),
                        Textarea::make('description')
                            ->label('Keterangan')
                            ->rows(3)
                            ->maxLength(600)
                            ->columnSpanFull(),
                        TextInput::make('sort_order')
                            ->label('Urutan tampil')
                            ->helperText('Angka lebih kecil tampil lebih awal.')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(65535)
                            ->default(0),
                    ]),
            ]);
    }
}
