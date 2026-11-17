<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi proyek')
                    ->description('Jelaskan karya dengan informasi yang dapat diverifikasi.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Nama proyek')
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
                            ->label('Alamat portofolio')
                            ->helperText('Dibuat dari nama proyek dan bisa disunting.')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash']),
                        TextInput::make('category')
                            ->label('Kategori')
                            ->helperText('Gunakan penamaan yang konsisten untuk proyek sejenis.')
                            ->required()
                            ->maxLength(80),
                        Textarea::make('summary')
                            ->label('Ringkasan')
                            ->helperText('Ringkasan ini tampil pada daftar portofolio.')
                            ->rows(3)
                            ->maxLength(1000)
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('details')
                            ->label('Uraian proyek')
                            ->helperText('Gunakan toolbar untuk menambahkan format, tautan, gambar, atau tabel.')
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'link'],
                                ['h2', 'h3'],
                                ['alignStart', 'alignCenter', 'alignEnd'],
                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                ['table', 'attachFiles'],
                                ['undo', 'redo'],
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('projects/content')
                            ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->fileAttachmentsMaxSize(5120)
                            ->columnSpanFull(),
                        TextInput::make('source_url')
                            ->label('Tautan sumber')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
                Section::make('Gambar proyek')
                    ->description('Unggah sampul proyek agar tampil konsisten di halaman portofolio.')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Berkas gambar')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->disk('public')
                            ->directory('projects')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->helperText('JPG, PNG, atau WebP. Maksimal 5 MB.'),
                        TextInput::make('thumbnail_alt')
                            ->label('Deskripsi gambar')
                            ->maxLength(255)
                            ->helperText('Jika dikosongkan, nama proyek dipakai sebagai teks alternatif.'),
                    ]),
                Section::make('Penerbitan')
                    ->description('Proyek terjadwal akan tampil otomatis pada tanggal yang dipilih.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Tampilkan di portofolio')
                            ->default(false)
                            ->live(),
                        DatePicker::make('published_at')
                            ->label('Tanggal terbit')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->required(fn (Get $get): bool => (bool) $get('is_published')),
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
