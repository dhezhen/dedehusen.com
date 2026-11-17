<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'hero_title',
        'hero_description',
        'font_display',
        'font_body',
        'color_accent',
        'color_background',
        'color_text',
        'color_dark_background',
        'color_dark_text',
        'color_dark_accent',
        'smtp_host',
        'smtp_port',
        'smtp_scheme',
        'smtp_username',
        'smtp_password',
        'smtp_from_address',
        'smtp_from_name',
        'contact_mail_to',
        'google_site_verification',
    ];

    protected $hidden = ['smtp_password'];

    protected function casts(): array
    {
        return [
            'smtp_password' => 'encrypted',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site-settings'));
        static::deleted(fn () => Cache::forget('site-settings'));
    }
}
