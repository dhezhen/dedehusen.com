<?php

namespace App\Enums;

enum CourseMaterialType: string
{
    case Rps = 'rps';
    case Slide = 'slide';
    case Module = 'module';
    case Practice = 'practice';
    case Reference = 'reference';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Rps => 'RPS',
            self::Slide => 'Slide presentasi',
            self::Module => 'Modul',
            self::Practice => 'Praktikum atau tugas',
            self::Reference => 'Bahan bacaan',
            self::Other => 'Lainnya',
        };
    }

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $type) {
            $options[$type->value] = $type->label();
        }

        return $options;
    }
}
