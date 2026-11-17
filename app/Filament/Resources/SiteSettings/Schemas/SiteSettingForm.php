<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
            ]);
    }
}
