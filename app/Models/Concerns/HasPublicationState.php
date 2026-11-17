<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasPublicationState
{
    public function scopePublished(Builder $query): Builder
    {
        $tomorrow = today()->addDay()->toDateString();

        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<', $tomorrow);
    }

    public function scopeScheduled(Builder $query): Builder
    {
        $tomorrow = today()->addDay()->toDateString();

        return $query
            ->where('is_published', true)
            ->where('published_at', '>=', $tomorrow);
    }

    public function publicationStatus(): string
    {
        if (! $this->is_published) {
            return 'Draf';
        }

        if (blank($this->published_at)) {
            return 'Tanggal belum diatur';
        }

        return $this->published_at->isAfter(today()) ? 'Terjadwal' : 'Terbit';
    }
}
