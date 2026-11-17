<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')->required()->maxLength(120),
                TextInput::make('hero_title')->required()->maxLength(160),
                Textarea::make('hero_description')->rows(3)->columnSpanFull(),
                TextInput::make('font_display')->required()->helperText('Gunakan nama font yang tersedia di Google Fonts.'),
                TextInput::make('font_body')->required()->helperText('Gunakan nama font yang tersedia di Google Fonts.'),
                ColorPicker::make('color_accent')->required(),
                ColorPicker::make('color_background')->required(),
                ColorPicker::make('color_text')->required(),
                ColorPicker::make('color_dark_background')->label('Latar mode gelap')->required(),
                ColorPicker::make('color_dark_text')->label('Teks mode gelap')->required(),
                ColorPicker::make('color_dark_accent')->label('Aksen mode gelap')->required(),
                Section::make('Verifikasi Google')
                    ->description('Masukkan kode verifikasi Google Search Console. Anda dapat menempelkan kode saja atau teks lengkap google-site-verification=...')
                    ->schema([
                        TextInput::make('google_site_verification')
                            ->label('Kode verifikasi situs')
                            ->maxLength(255),
                    ]),
                Section::make('Email dan SMTP')
                    ->description('Dipakai untuk formulir kontak dan reset password. Simpan dulu, lalu uji pengiriman ke alamat admin. Password dienkripsi; kosongkan kolomnya untuk mempertahankan password tersimpan.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('smtp_host')
                            ->label('Host SMTP')
                            ->placeholder('mail.example.com')
                            ->maxLength(255),
                        TextInput::make('smtp_port')
                            ->label('Port SMTP')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(65535),
                        Select::make('smtp_scheme')
                            ->label('Enkripsi koneksi')
                            ->options([
                                'smtp' => 'STARTTLS',
                                'smtps' => 'SSL/TLS',
                            ])
                            ->placeholder('Otomatis sesuai port'),
                        TextInput::make('smtp_username')
                            ->label('Username SMTP')
                            ->maxLength(255),
                        TextInput::make('smtp_password')
                            ->label('Password SMTP')
                            ->password()
                            ->revealable()
                            ->formatStateUsing(fn (): null => null)
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                        TextInput::make('smtp_from_address')
                            ->label('Alamat email pengirim')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('smtp_from_name')
                            ->label('Nama pengirim')
                            ->maxLength(255),
                        TextInput::make('contact_mail_to')
                            ->label('Alamat penerima formulir kontak')
                            ->email()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
