<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->disabled(),
                TextInput::make('email')->email()->disabled(),
                TextInput::make('topic')->disabled(),
                Textarea::make('message')->rows(8)->disabled()->columnSpanFull(),
                DateTimePicker::make('read_at')->label('Ditandai dibaca pada'),
            ]);
    }
}
