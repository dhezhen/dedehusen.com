<?php

namespace App\Filament\Resources\CourseMaterials\Schemas;

use App\Enums\CourseMaterialType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class CourseMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Materi')
                    ->description('Pilih mata kuliah dan jelaskan bahan yang dibagikan.')
                    ->columns(2)
                    ->schema([
                        Select::make('course_id')
                            ->label('Mata kuliah')
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('material_type')
                            ->label('Jenis materi')
                            ->options(CourseMaterialType::options())
                            ->placeholder('Pilih jenis materi')
                            ->required(),
                        TextInput::make('title')
                            ->label('Judul materi')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Keterangan')
                            ->helperText('Sebutkan isi atau kegunaan materi secara singkat.')
                            ->rows(3)
                            ->maxLength(600)
                            ->columnSpanFull(),
                    ]),
                Section::make('Berkas atau tautan')
                    ->description('Setiap materi memiliki satu berkas unduhan atau satu tautan.')
                    ->columns(2)
                    ->schema([
                        Select::make('resource_type')
                            ->label('Sumber materi')
                            ->options([
                                'file' => 'Berkas untuk diunduh',
                                'link' => 'Tautan eksternal',
                            ])
                            ->default('file')
                            ->live()
                            ->afterStateUpdated(function (?string $state, Set $set): void {
                                if ($state === 'file') {
                                    $set('external_url', null);

                                    return;
                                }

                                $set('file_path', null);
                            })
                            ->required(),
                        FileUpload::make('file_path')
                            ->label('Berkas materi')
                            ->disk('public')
                            ->directory('course-materials')
                            ->visibility('public')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/zip',
                            ])
                            ->maxSize(20480)
                            ->visible(fn (Get $get): bool => $get('resource_type') === 'file')
                            ->required(fn (Get $get): bool => $get('resource_type') === 'file')
                            ->helperText('PDF, Office, atau ZIP. Maksimal 20 MB.'),
                        TextInput::make('external_url')
                            ->label('Alamat tautan')
                            ->url()
                            ->maxLength(2048)
                            ->visible(fn (Get $get): bool => $get('resource_type') === 'link')
                            ->required(fn (Get $get): bool => $get('resource_type') === 'link')
                            ->columnSpanFull(),
                    ]),
                Section::make('Penerbitan')
                    ->description('Materi terjadwal tampil otomatis setelah tanggal terbit.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Tampilkan materi')
                            ->default(false)
                            ->live(),
                        DatePicker::make('published_at')
                            ->label('Tanggal terbit')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->required(fn (Get $get): bool => (bool) $get('is_published')),
                        TextInput::make('sort_order')
                            ->label('Urutan dalam mata kuliah')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(65535)
                            ->default(0),
                    ]),
            ]);
    }
}
