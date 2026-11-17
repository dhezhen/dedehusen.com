<?php

namespace App\Enums;

enum ArticleCategory: string
{
    case Education = 'pendidikan';
    case Research = 'penelitian';
    case CommunityService = 'pengabdian';
    case Technology = 'teknologi';

    public function label(): string
    {
        return match ($this) {
            self::Education => 'Pendidikan',
            self::Research => 'Penelitian',
            self::CommunityService => 'Pengabdian',
            self::Technology => 'Teknologi',
        };
    }

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $category) {
            $options[$category->value] = $category->label();
        }

        return $options;
    }
}
