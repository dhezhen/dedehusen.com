<?php

namespace App\Models;

use App\Models\Concerns\HasPublicationState;
use App\Support\ContentHtmlSanitizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasPublicationState;

    protected $fillable = ['title', 'slug', 'category', 'summary', 'details', 'thumbnail', 'thumbnail_alt', 'source_url', 'published_at', 'is_published', 'sort_order'];

    protected function casts(): array
    {
        return ['published_at' => 'date', 'is_published' => 'boolean'];
    }

    public function getDetailsHtmlAttribute(): string
    {
        $details = $this->details ?? '';

        if (! str_contains($details, '<')) {
            return nl2br(e($details));
        }

        return app(ContentHtmlSanitizer::class)->sanitize($details);
    }

    public function setDetailsAttribute(?string $value): void
    {
        $this->attributes['details'] = app(ContentHtmlSanitizer::class)->sanitize($value);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (blank($this->thumbnail)) {
            return null;
        }

        if (Str::startsWith($this->thumbnail, ['http://', 'https://', '/storage/'])) {
            return $this->thumbnail;
        }

        if (Str::startsWith($this->thumbnail, 'projects/')) {
            return Storage::disk('public')->url($this->thumbnail);
        }

        return asset($this->thumbnail);
    }
}
