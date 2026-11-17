<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\ArticleCategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Naskah artikel')
                    ->description('Tulis judul dan isi yang akan dibaca pengunjung.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul artikel')
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
                            ->label('Alamat artikel')
                            ->helperText('Dibuat dari judul dan bisa disunting. Gunakan huruf, angka, dan tanda hubung.')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash']),
                        Select::make('category')
                            ->label('Kategori')
                            ->options(ArticleCategory::options())
                            ->in(array_keys(ArticleCategory::options()))
                            ->placeholder('Pilih kategori')
                            ->helperText('Kategori dipakai untuk menyaring tulisan.')
                            ->required(),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->helperText('Ringkasan tampil pada kartu artikel dan hasil pencarian.')
                            ->rows(3)
                            ->maxLength(600)
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('body')
                            ->label('Isi artikel')
                            ->helperText('Gunakan toolbar untuk format teks, tautan, gambar, dan tabel. Gambar dibatasi 5 MB.')
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'link'],
                                ['h2', 'h3'],
                                ['alignStart', 'alignCenter', 'alignEnd'],
                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                ['table', 'attachFiles'],
                                ['undo', 'redo'],
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('articles/content')
                            ->fileAttachmentsAcceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->fileAttachmentsMaxSize(5120)
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Gambar sampul')
                    ->description('Gunakan gambar yang mewakili isi artikel.')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Berkas gambar')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->disk('public')
                            ->directory('articles')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->helperText('JPG, PNG, atau WebP. Maksimal 5 MB.'),
                        TextInput::make('thumbnail_alt')
                            ->label('Deskripsi gambar')
                            ->maxLength(255)
                            ->helperText('Jelaskan informasi pada gambar. Jika dikosongkan, judul artikel dipakai sebagai teks alternatif.'),
                    ]),
                Section::make('Penerbitan')
                    ->description('Simpan sebagai draf atau jadwalkan agar tampil pada tanggal tertentu.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Terbitkan artikel')
                            ->helperText('Aktifkan untuk menerbitkan atau menjadwalkan artikel.')
                            ->default(false)
                            ->live(),
                        DatePicker::make('published_at')
                            ->label('Tanggal terbit')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->required(fn (Get $get): bool => (bool) $get('is_published'))
                            ->helperText('Tanggal mendatang akan menjadi jadwal terbit.'),
                    ]),
            ]);
    }
}
