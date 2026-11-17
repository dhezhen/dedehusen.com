<?php

namespace App\Models;

use App\Models\Concerns\HasPublicationState;
use App\Support\ContentHtmlSanitizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasPublicationState;

    protected $fillable = ['title', 'slug', 'category', 'excerpt', 'body', 'thumbnail', 'thumbnail_alt', 'published_at', 'is_published'];

    protected function casts(): array
    {
        return ['published_at' => 'date', 'is_published' => 'boolean'];
    }

    public function getBodyHtmlAttribute(): string
    {
        $body = $this->body ?? '';

        if (! str_contains($body, '<')) {
            return nl2br(e($body));
        }

        return app(ContentHtmlSanitizer::class)->sanitize($body);
    }

    public function setBodyAttribute(?string $value): void
    {
        $this->attributes['body'] = app(ContentHtmlSanitizer::class)->sanitize($value);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (blank($this->thumbnail)) {
            return null;
        }

        if (Str::startsWith($this->thumbnail, ['http://', 'https://', '/storage/'])) {
            return $this->thumbnail;
        }

        if (Str::startsWith($this->thumbnail, 'articles/')) {
            return Storage::disk('public')->url($this->thumbnail);
        }

        return asset($this->thumbnail);
    }
}
